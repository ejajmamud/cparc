<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingPaymentResource\Pages;
use App\Models\Booking;
use App\Models\BookingPayment;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;

class BookingPaymentResource extends Resource
{
    protected static ?string $model = BookingPayment::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-banknotes';
    protected static \UnitEnum|string|null $navigationGroup = 'Bookings';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationLabel = 'Payments';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Forms\Components\Select::make('booking_id')
                ->label('Booking Reference')
                ->options(Booking::whereIn('status', ['pending','confirmed'])->pluck('reference_number', 'id'))
                ->searchable()->required(),
            Forms\Components\Select::make('payment_type')
                ->options([
                    'advance' => 'Advance / Deposit',
                    'full'    => 'Full Payment',
                    'balance' => 'Balance Payment',
                    'refund'  => 'Refund',
                ])->required()->default('advance'),
            Forms\Components\TextInput::make('amount')->numeric()->prefix('৳')->required()->label('Amount (BDT)'),
            Forms\Components\Select::make('payment_method')
                ->options([
                    'cash'   => 'Cash',
                    'bkash'  => 'bKash',
                    'nagad'  => 'Nagad',
                    'bank'   => 'Bank Transfer',
                    'cheque' => 'Cheque',
                ])->required(),
            Forms\Components\TextInput::make('transaction_id')->label('Transaction / Cheque #'),
            Forms\Components\DatePicker::make('payment_date')->required()->native(false)->default(today()),
            Forms\Components\TextInput::make('received_by')->label('Received By (Staff Name)'),
            Forms\Components\Textarea::make('notes')->rows(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking.reference_number')->label('Booking Ref')->searchable()->sortable()->weight('bold')->color('primary'),
                Tables\Columns\TextColumn::make('booking.booker_name')->label('Booker')->searchable(),
                Tables\Columns\TextColumn::make('payment_type')->badge()
                    ->color(fn($s) => match($s) { 'advance'=>'warning','full'=>'success','balance'=>'info','refund'=>'danger', default=>'gray' }),
                Tables\Columns\TextColumn::make('amount')->formatStateUsing(fn($s) => '৳'.number_format($s))->sortable(),
                Tables\Columns\TextColumn::make('payment_method')->badge(),
                Tables\Columns\TextColumn::make('transaction_id')->label('Txn #')->searchable(),
                Tables\Columns\TextColumn::make('payment_date')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('received_by')->label('By')->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('payment_date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('payment_type')
                    ->options(['advance'=>'Advance','full'=>'Full','balance'=>'Balance','refund'=>'Refund']),
                Tables\Filters\SelectFilter::make('payment_method')
                    ->options(['cash'=>'Cash','bkash'=>'bKash','nagad'=>'Nagad','bank'=>'Bank','cheque'=>'Cheque']),
            ])
            ->actions([Actions\EditAction::make(), Actions\DeleteAction::make()])
            ->bulkActions([Actions\BulkActionGroup::make([Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBookingPayments::route('/'),
            'create' => Pages\CreateBookingPayment::route('/create'),
            'edit'   => Pages\EditBookingPayment::route('/{record}/edit'),
        ];
    }
}
