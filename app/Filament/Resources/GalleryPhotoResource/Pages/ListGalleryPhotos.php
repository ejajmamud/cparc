<?php

namespace App\Filament\Resources\GalleryPhotoResource\Pages;

use App\Filament\Resources\GalleryPhotoResource;
use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\Storage;

class ListGalleryPhotos extends ListRecords
{
    protected static string $resource = GalleryPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('bulkUpload')
                ->label('Bulk Upload')
                ->icon('heroicon-o-arrow-up-tray')
                ->color('success')
                ->form(fn (Schema $schema) => $schema->schema([
                    Select::make('gallery_album_id')
                        ->label('Album')
                        ->options(GalleryAlbum::pluck('name', 'id'))
                        ->searchable()
                        ->required(),

                    FileUpload::make('files')
                        ->label('Images / Videos (select multiple)')
                        ->disk('public')
                        ->directory('gallery')
                        ->multiple()
                        ->maxFiles(999)
                        ->maxSize(256 * 1024)
                        ->acceptedFileTypes(['image/jpeg','image/png','image/webp','image/gif','video/mp4','video/webm','video/ogg','video/quicktime'])
                        ->required(),
                ]))
                ->action(function (array $data): void {
                    $videoExts = ['mp4','webm','mov','ogg','avi'];
                    $count = 0;
                    foreach ((array) ($data['files'] ?? []) as $path) {
                        $ext  = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                        $type = in_array($ext, $videoExts) ? 'video' : 'image';
                        GalleryPhoto::create([
                            'gallery_album_id' => $data['gallery_album_id'],
                            'path'             => $path,
                            'type'             => $type,
                            'is_published'     => true,
                            'sort_order'       => 0,
                        ]);
                        $count++;
                    }
                    Notification::make()
                        ->title("$count item(s) uploaded successfully")
                        ->success()
                        ->send();
                }),

            Actions\CreateAction::make()->label('Add Single'),
        ];
    }
}
