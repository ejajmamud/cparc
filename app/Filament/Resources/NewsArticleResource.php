<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NewsArticleResource\Pages;
use App\Models\NewsArticle;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class NewsArticleResource extends Resource
{
    protected static ?string $model = NewsArticle::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-newspaper';
    protected static \UnitEnum|string|null $navigationGroup = 'Content';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationLabel = 'News Articles';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('English')->columns(2)->schema([
                Forms\Components\TextInput::make('title')->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
                Forms\Components\RichEditor::make('content')->columnSpanFull(),
            ]),
            Section::make('বাংলা (Bengali)')->columns(1)->schema([
                Forms\Components\TextInput::make('title_bn')->label('Title (Bengali)'),
                Forms\Components\RichEditor::make('content_bn')->label('Content (Bengali)')->columnSpanFull(),
            ]),
            Section::make('Settings & Media')->columns(2)->schema([
                Forms\Components\Toggle::make('is_published')->default(true),
                Forms\Components\DateTimePicker::make('published_at')->default(now()),
                Forms\Components\FileUpload::make('image')->image()->directory('news')->label('Featured Image')->disk('public')->columnSpanFull(),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->limit(50)->sortable(),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
                Tables\Columns\TextColumn::make('published_at')->dateTime('d M Y')->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListNewsArticles::route('/'),
            'create' => Pages\CreateNewsArticle::route('/create'),
            'edit'   => Pages\EditNewsArticle::route('/{record}/edit'),
        ];
    }
}
