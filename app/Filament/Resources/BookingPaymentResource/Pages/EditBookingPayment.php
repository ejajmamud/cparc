<?php
namespace App\Filament\Resources\BookingPaymentResource\Pages;
use App\Filament\Resources\BookingPaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
class EditBookingPayment extends EditRecord {
    protected static string $resource = BookingPaymentResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}