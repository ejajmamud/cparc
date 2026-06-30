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
use Illuminate\Support\Facades\Storage;

class GalleryPhotoResource extends Resource
{
    protected static ?string $model = GalleryPhoto::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-camera';
    protected static \UnitEnum|string|null $navigationGroup = 'Media';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\Select::make('gallery_album_id')
                ->label('Album')
                ->options(GalleryAlbum::pluck('name', 'id'))
                ->searchable()
                ->required(),

            Forms\Components\Select::make('type')
                ->label('Media Type')
                ->options(['image' => 'Image', 'video' => 'Video'])
                ->default('image')
                ->required()
                ->live(),

            Forms\Components\FileUpload::make('path')
                ->label('File')
                ->disk('public')
                ->directory('gallery')
                ->required()
                ->acceptedFileTypes(['image/jpeg','image/png','image/webp','image/gif','video/mp4','video/webm','video/ogg','video/quicktime'])
                ->maxSize(256 * 1024),

            Forms\Components\TextInput::make('caption'),
            Forms\Components\TextInput::make('sort_order')->numeric()->default(0),
            Forms\Components\Toggle::make('is_published')->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('path')
                    ->label('Preview')
                    ->getStateUsing(fn($record) => in_array(strtolower(pathinfo($record->path ?? '', PATHINFO_EXTENSION)), ['mp4','webm','mov','ogg'])
                        ? null
                        : (str_starts_with($record->path ?? '', 'images/') ? asset($record->path) : asset('storage/'.$record->path))),
                Tables\Columns\TextColumn::make('type')->badge()
                    ->color(fn(string $state): string => $state === 'video' ? 'warning' : 'success'),
                Tables\Columns\TextColumn::make('album.name')->label('Album'),
                Tables\Columns\TextColumn::make('caption')->limit(40),
                Tables\Columns\TextColumn::make('sort_order')->sortable()->label('Order'),
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
