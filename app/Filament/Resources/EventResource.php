<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use App\Models\Tag;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-calendar';
    protected static \UnitEnum|string|null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('English Content')->columns(2)->schema([
                Forms\Components\TextInput::make('title')->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\TextInput::make('venue')->label('Venue / Location'),
                Forms\Components\TextInput::make('organizer')->label('Organizer / Host'),
                Forms\Components\Textarea::make('description')->rows(4)->columnSpanFull(),
            ]),
            Section::make('বাংলা (Bengali)')->columns(2)->schema([
                Forms\Components\TextInput::make('title_bn')->label('শিরোনাম (Bengali)'),
                Forms\Components\TextInput::make('venue_bn')->label('স্থান (Bengali)'),
                Forms\Components\TextInput::make('organizer_bn')->label('আয়োজক (Bengali)'),
                Forms\Components\Textarea::make('description_bn')->label('বিবরণ (Bengali)')->rows(4)->columnSpanFull(),
            ]),
            Section::make('Date & Time')->columns(3)->schema([
                Forms\Components\DatePicker::make('event_date')->required()->native(false)->label('Event Date'),
                Forms\Components\DatePicker::make('end_date')->native(false)->label('End Date (multi-day)'),
                Forms\Components\TextInput::make('time')->label('Display Time (e.g. 6:00 PM)'),
                Forms\Components\TimePicker::make('start_time')->seconds(false)->label('Start Time'),
                Forms\Components\TimePicker::make('end_time')->seconds(false)->label('End Time'),
                Forms\Components\TextInput::make('age_limit')->label('Age Limit (e.g. 18+, All ages)')->placeholder('All ages'),
            ]),
            Section::make('Media & Settings')->columns(2)->schema([
                Forms\Components\FileUpload::make('image')->image()->disk('public')->directory('events')->label('Event Image'),
                Forms\Components\TextInput::make('expected_guests')->numeric()->label('Expected Guests'),
                Forms\Components\Select::make('tags')
                    ->label('Tags')
                    ->multiple()
                    ->relationship('tags', 'name')
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_published')->default(true),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->limit(40)->sortable(),
                Tables\Columns\TextColumn::make('event_date')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('venue')->limit(25),
                Tables\Columns\TextColumn::make('organizer')->limit(20)->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('age_limit')->label('Age')->badge()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_published')->boolean()->label('Published'),
                Tables\Columns\TextColumn::make('tags.name')->badge()->separator(',')->label('Tags'),
            ])
            ->defaultSort('event_date', 'desc')
            ->filters([
                Tables\Filters\Filter::make('upcoming')
                    ->query(fn($q) => $q->upcoming())
                    ->label('Upcoming Only'),
                Tables\Filters\Filter::make('past')
                    ->query(fn($q) => $q->past())
                    ->label('Past Only'),
                Tables\Filters\SelectFilter::make('tags')->relationship('tags', 'name')->multiple(),
            ])
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit'   => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
