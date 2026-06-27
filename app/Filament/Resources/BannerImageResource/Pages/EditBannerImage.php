<?php

namespace App\Filament\Resources\BannerImageResource\Pages;

use App\Filament\Resources\BannerImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBannerImage extends EditRecord
{
    protected static string $resource = BannerImageResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
