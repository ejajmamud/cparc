<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use App\Models\Package;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Resources\Resource;
use Filament\Actions;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-calendar-days';
    protected static \UnitEnum|string|null $navigationGroup = 'Bookings';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Hall Bookings';

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Booker Information')->columns(2)->schema([
                Forms\Components\TextInput::make('reference_number')->disabled()->label('Reference #'),
                Forms\Components\Select::make('status')
                    ->options([
                        'pending'   => '🕐 Pending',
                        'confirmed' => '✅ Confirmed',
                        'cancelled' => '❌ Cancelled',
                        'completed' => '🏁 Completed',
                    ])
                    ->required()
                    ->live(),
                Forms\Components\TextInput::make('booker_name')->required()->label('Full Name'),
                Forms\Components\TextInput::make('booker_phone')->required()->label('Phone'),
                Forms\Components\TextInput::make('booker_email')->email()->label('Email'),
                Forms\Components\TextInput::make('booker_nid')->label('NID'),
                Forms\Components\Textarea::make('booker_address')->rows(2)->columnSpanFull()->label('Address'),
            ]),

            Section::make('Event Details')->columns(2)->schema([
                Forms\Components\Select::make('package_id')
                    ->label('Package')
                    ->options(Package::where('is_active', true)->pluck('name', 'id'))
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $pkg = Package::find($state);
                        if ($pkg) $set('total_amount', $pkg->price);
                    }),
                Forms\Components\Select::make('event_type')
                    ->options([
                        'wedding'   => 'Wedding / বিবাহ',
                        'reception' => 'Reception / রিসেপশন',
                        'birthday'  => 'Birthday / জন্মদিন',
                        'corporate' => 'Corporate Event',
                        'cultural'  => 'Cultural Programme',
                        'seminar'   => 'Seminar / Conference',
                        'other'     => 'Other',
                    ])->required()->label('Event Type'),
                Forms\Components\DatePicker::make('event_date')->required()->native(false)->label('Event Date'),
                Forms\Components\TextInput::make('guests_count')->numeric()->label('Expected Guests'),
                Forms\Components\TimePicker::make('start_time')->seconds(false)->label('Start Time'),
                Forms\Components\TimePicker::make('end_time')->seconds(false)->label('End Time'),
                Forms\Components\Textarea::make('special_requests')->rows(3)->columnSpanFull()->label('Special Requests'),
            ]),

            Section::make('Payment & Admin')->columns(2)->schema([
                Forms\Components\TextInput::make('total_amount')->numeric()->prefix('৳')->label('Total Amount (BDT)'),
                Forms\Components\TextInput::make('advance_paid')->numeric()->prefix('৳')->label('Advance Paid (BDT)')->default(0),
                Forms\Components\Select::make('payment_method')
                    ->options([
                        'cash'  => 'Cash',
                        'bkash' => 'bKash',
                        'nagad' => 'Nagad',
                        'bank'  => 'Bank Transfer',
                        'cheque'=> 'Cheque',
                    ])->label('Payment Method'),
                Forms\Components\TextInput::make('transaction_id')->label('Transaction / Cheque ID'),
                Forms\Components\Textarea::make('admin_notes')->rows(3)->columnSpanFull()->label('Admin Notes'),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('reference_number')
                    ->label('Ref #')->searchable()->sortable()->weight('bold')
                    ->color('primary'),
                Tables\Columns\TextColumn::make('booker_name')->searchable()->label('Booker')->limit(25),
                Tables\Columns\TextColumn::make('booker_phone')->label('Phone')->searchable(),
                Tables\Columns\TextColumn::make('package.name')->label('Package')->badge(),
                Tables\Columns\TextColumn::make('event_type')->label('Event')
                    ->formatStateUsing(fn($state) => ucfirst($state))->badge(),
                Tables\Columns\TextColumn::make('event_date')->label('Date')->date('d M Y')->sortable(),
                Tables\Columns\TextColumn::make('status')->badge()
                    ->color(fn($state) => match($state) {
                        'pending'   => 'warning',
                        'confirmed' => 'success',
                        'cancelled' => 'danger',
                        'completed' => 'info',
                        default     => 'gray',
                    }),
                Tables\Columns\TextColumn::make('total_amount')->label('Amount')
                    ->formatStateUsing(fn($state) => '৳' . number_format($state))->sortable(),
                Tables\Columns\TextColumn::make('advance_paid')->label('Advance')
                    ->formatStateUsing(fn($state) => '৳' . number_format($state)),
                Tables\Columns\TextColumn::make('created_at')->label('Submitted')->dateTime('d M Y')->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'   => 'Pending',
                        'confirmed' => 'Confirmed',
                        'cancelled' => 'Cancelled',
                        'completed' => 'Completed',
                    ]),
                Tables\Filters\SelectFilter::make('package_id')
                    ->label('Package')
                    ->relationship('package', 'name'),
                Tables\Filters\Filter::make('event_date')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('From Date'),
                        Forms\Components\DatePicker::make('until')->label('Until Date'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['from'],  fn($q, $v) => $q->whereDate('event_date', '>=', $v))
                            ->when($data['until'], fn($q, $v) => $q->whereDate('event_date', '<=', $v));
                    }),
            ])
            ->actions([
                Actions\Action::make('confirm')
                    ->label('Confirm')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn($record) => $record->status === 'pending')
                    ->action(fn($record) => $record->update(['status' => 'confirmed', 'confirmed_at' => now()])),
                Actions\Action::make('cancel')
                    ->label('Cancel')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->visible(fn($record) => in_array($record->status, ['pending', 'confirmed']))
                    ->action(fn($record) => $record->update(['status' => 'cancelled', 'cancelled_at' => now()])),
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit'   => Pages\EditBooking::route('/{record}/edit'),
        ];
    }
}
