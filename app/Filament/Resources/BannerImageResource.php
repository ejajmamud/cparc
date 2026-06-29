<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerImageResource\Pages;
use App\Models\BannerImage;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;

class BannerImageResource extends Resource
{
    protected static ?string $model = BannerImage::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-photo';
    protected static \UnitEnum|string|null $navigationGroup = 'Media';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Banner Images';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\FileUpload::make('path')->image()->directory('banners')->required(),
            Forms\Components\TextInput::make('caption'),
            Forms\Components\TextInput::make('link'),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_active')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('path')->label('Image')
                    ->url(fn($record) => str_contains($record->path ?? '', '/')
                        ? asset('storage/' . $record->path)
                        : asset($record->path ?? '')),
                Tables\Columns\TextColumn::make('path')->label('File')->limit(50),
                Tables\Columns\TextColumn::make('caption'),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->reorderable('sort_order')
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBannerImages::route('/'),
            'create' => Pages\CreateBannerImage::route('/create'),
            'edit'   => Pages\EditBannerImage::route('/{record}/edit'),
        ];
    }
}