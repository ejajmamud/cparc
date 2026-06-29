<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryPhotoResource\Pages;
use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;

class GalleryPhotoResource extends Resource
{
    protected static ?string $model = GalleryPhoto::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-camera';
    protected static \UnitEnum|string|null $navigationGroup = 'Media';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\Select::make('gallery_album_id')->label('Album')
                ->options(GalleryAlbum::pluck('name', 'id'))->searchable()->required(),
            Forms\Components\FileUpload::make('path')->image()->directory('gallery')->required(),
            Forms\Components\TextInput::make('caption'),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_published')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('path')->label('Photo')
                    ->url(fn($record) => str_contains($record->path ?? '', '/')
                        ? asset('storage/' . $record->path)
                        : asset($record->path ?? '')),
                Tables\Columns\TextColumn::make('album.name')->label('Album'),
                Tables\Columns\TextColumn::make('caption')->limit(40),
                Tables\Columns\TextColumn::make('sort_order')->sortable(),
                Tables\Columns\IconColumn::make('is_published')->boolean(),
            ])
            ->defaultSort('sort_order')
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListGalleryPhotos::route('/'),
            'create' => Pages\CreateGalleryPhoto::route('/create'),
            'edit'   => Pages\EditGalleryPhoto::route('/{record}/edit'),
        ];
    }
}