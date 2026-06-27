<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NoticeResource\Pages;
use App\Models\Notice;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class NoticeResource extends Resource
{
    protected static ?string $model = Notice::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-bell';
    protected static \UnitEnum|string|null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('English Content')->columns(2)->schema([
                Forms\Components\TextInput::make('title')->required()->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\RichEditor::make('content')->columnSpanFull(),
            ]),
            Section::make('বাংলা কন্টেন্ট (Bengali)')->columns(1)->schema([
                Forms\Components\TextInput::make('title_bn')->label('Title (Bengali)'),
                Forms\Components\Textarea::make('content_bn')->label('Content (Bengali)')->rows(5),
            ]),
            Section::make('Settings')->columns(3)->schema([
                Forms\Components\Select::make('type')->options(['general'=>'General','tender'=>'Tender','recruitment'=>'Recruitment'])->required()->default('general'),
                Forms\Components\Toggle::make('is_new')->label('Mark as New')->default(true),
                Forms\Components\Toggle::make('is_published')->label('Published')->default(true),
                Forms\Components\DateTimePicker::make('published_at')->default(now()),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->limit(50)->sortable(),
                Tables\Columns\TextColumn::make('type')->badge()
                    ->color(fn($state) => match($state) { 'general'=>'primary','tender'=>'warning','recruitment'=>'success', default=>'gray' }),
                Tables\Columns\IconColumn::make('is_new')->boolean()->label('New'),
                Tables\Columns\IconColumn::make('is_published')->boolean()->label('Published'),
                Tables\Columns\TextColumn::make('published_at')->dateTime('d M Y')->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')->options(['general'=>'General','tender'=>'Tender','recruitment'=>'Recruitment']),
            ])
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])])
            ->defaultSort('published_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListNotices::route('/'),
            'create' => Pages\CreateNotice::route('/create'),
            'edit'   => Pages\EditNotice::route('/{record}/edit'),
        ];
    }
}
