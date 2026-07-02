<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountTransactionResource\Pages;
use App\Models\AccountTransaction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AccountTransactionResource extends Resource
{
    protected static ?string $model = AccountTransaction::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-banknotes';
    protected static \UnitEnum|string|null $navigationGroup = 'Finance';
    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return app()->getLocale() === 'bn' ? 'আয়-ব্যয়' : 'Accounts';
    }

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('লেনদেনের তথ্য / Transaction Info')->schema([
                Grid::make(3)->schema([
                    DatePicker::make('deposit_date')
                        ->label('জমা/উত্তোলনের তারিখ (Deposit Date)')
                        ->required()
                        ->default(now()),

                    DatePicker::make('event_date')
                        ->label('অনুষ্ঠানের তারিখ (Event Date)')
                        ->nullable(),

                    TextInput::make('voucher_number')
                        ->label('ভাউচার নং (Voucher No.)')
                        ->placeholder('Auto if empty')
                        ->unique(ignoreRecord: true),
                ]),

                Grid::make(2)->schema([
                    Select::make('type')
                        ->label('ধরন (Type)')
                        ->options([
                            'income'  => '⬆ Income / আয়',
                            'expense' => '⬇ Expense / ব্যয়',
                        ])
                        ->required()
                        ->default('income'),

                    Select::make('category')
                        ->label('বিভাগ (Category)')
                        ->options(AccountTransaction::categories())
                        ->default('hall_rental')
                        ->required(),
                ]),
            ]),

            Section::make('পরিমাণ / Amounts')->schema([
                Grid::make(4)->schema([
                    TextInput::make('income_amount')
                        ->label('আয়/জমা (Income ৳)')
                        ->numeric()->prefix('৳')->default(0),

                    TextInput::make('expense_amount')
                        ->label('ব্যয়/উত্তোলন (Expense ৳)')
                        ->numeric()->prefix('৳')->default(0),

                    TextInput::make('electricity_bill')
                        ->label('বিদ্যুৎ বিল (Electricity ৳)')
                        ->numeric()->prefix('৳')->default(0),

                    TextInput::make('refund_amount')
                        ->label('ফেরত (Refund ৳)')
                        ->numeric()->prefix('৳')->default(0),
                ]),
            ]),

            Section::make('ব্যাংক/চেক তথ্য / Bank & Cheque')->schema([
                Grid::make(3)->schema([
                    Select::make('payment_method')
                        ->label('পদ্ধতি (Method)')
                        ->options([
                            'cash'           => 'Cash / নগদ',
                            'cheque'         => 'Cheque / চেক',
                            'bank_transfer'  => 'Bank Transfer',
                            'mobile_banking' => 'Mobile Banking',
                            'other'          => 'Other',
                        ])
                        ->default('cash'),

                    TextInput::make('cheque_number')
                        ->label('চেক নম্বর (Cheque No.)'),

                    TextInput::make('cheque_serial')
                        ->label('সিরিয়াল নং (Serial No.)'),
                ]),

                Grid::make(2)->schema([
                    TextInput::make('bank_name')
                        ->label('ব্যাংকের নাম (Bank Name)'),

                    TextInput::make('bank_deposit_details')
                        ->label('ব্যাংক জমার বিবরণ (Bank Deposit Details)'),
                ]),
            ]),

            Section::make('অতিরিক্ত তথ্য / Additional')->schema([
                Textarea::make('description')
                    ->label('বিবরণ (Description)')
                    ->rows(2),

                Grid::make(2)->schema([
                    TextInput::make('approved_by')
                        ->label('অনুমোদনকারী (Approved By)'),

                    FileUpload::make('attachment')
                        ->label('সংযুক্তি (Attachment)')
                        ->disk('public')
                        ->directory('accounts/attachments')
                        ->acceptedFileTypes(['image/jpeg','image/png','application/pdf'])
                        ->maxSize(5120),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ক্রঃ নং')
                    ->sortable()
                    ->width(60),

                TextColumn::make('deposit_date')
                    ->label('জমা তারিখ')
                    ->date('d-m-Y')
                    ->sortable(),

                TextColumn::make('event_date')
                    ->label('অনুষ্ঠান তারিখ')
                    ->date('d-m-Y')
                    ->placeholder('—'),

                TextColumn::make('type')
                    ->label('ধরন')
                    ->badge()
                    ->color(fn($state) => $state === 'income' ? 'success' : 'danger')
                    ->formatStateUsing(fn($state) => $state === 'income' ? '⬆ আয়' : '⬇ ব্যয়'),

                TextColumn::make('income_amount')
                    ->label('আয়/জমা ৳')
                    ->formatStateUsing(fn($state) => $state > 0 ? '৳ ' . number_format($state, 0) : '—')
                    ->color('success'),

                TextColumn::make('expense_amount')
                    ->label('ব্যয়/উত্তোলন ৳')
                    ->formatStateUsing(fn($state) => $state > 0 ? '৳ ' . number_format($state, 0) : '—')
                    ->color('danger'),

                TextColumn::make('electricity_bill')
                    ->label('বিদ্যুৎ বিল ৳')
                    ->formatStateUsing(fn($state) => $state > 0 ? '৳ ' . number_format($state, 0) : '—')
                    ->color('warning'),

                TextColumn::make('cheque_number')
                    ->label('চেক নং')
                    ->placeholder('—'),

                TextColumn::make('cheque_serial')
                    ->label('সিরিয়াল নং')
                    ->placeholder('—'),

                TextColumn::make('refund_amount')
                    ->label('ফেরত ৳')
                    ->formatStateUsing(fn($state) => $state > 0 ? '৳ ' . number_format($state, 0) : '—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('bank_deposit_details')
                    ->label('ব্যাংক বিবরণ')
                    ->limit(30)
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('description')
                    ->label('বিবরণ')
                    ->limit(35)
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('voucher_number')
                    ->label('ভাউচার')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('deposit_date', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label('Type')
                    ->options(['income' => 'Income / আয়', 'expense' => 'Expense / ব্যয়']),

                SelectFilter::make('month')
                    ->label('Month / মাস')
                    ->options([
                        1=>'January',2=>'February',3=>'March',4=>'April',
                        5=>'May',6=>'June',7=>'July',8=>'August',
                        9=>'September',10=>'October',11=>'November',12=>'December',
                    ]),

                SelectFilter::make('year')
                    ->label('Year / বছর')
                    ->options(array_combine(
                        range(now()->year, now()->year - 5),
                        range(now()->year, now()->year - 5)
                    )),

                Filter::make('date_range')
                    ->form([
                        DatePicker::make('from')->label('From / থেকে'),
                        DatePicker::make('until')->label('Until / পর্যন্ত'),
                    ])
                    ->query(fn(Builder $q, array $data) => $q
                        ->when($data['from'], fn($q) => $q->whereDate('deposit_date', '>=', $data['from']))
                        ->when($data['until'], fn($q) => $q->whereDate('deposit_date', '<=', $data['until']))
                    ),
            ])
            ->headerActions([
                Tables\Actions\Action::make('monthly_pdf')
                    ->label('📄 Monthly PDF')
                    ->color('danger')
                    ->form([
                        Select::make('month')
                            ->label('Month / মাস')
                            ->options([
                                1=>'January / জানুয়ারি',2=>'February / ফেব্রুয়ারি',
                                3=>'March / মার্চ',4=>'April / এপ্রিল',
                                5=>'May / মে',6=>'June / জুন',
                                7=>'July / জুলাই',8=>'August / আগস্ট',
                                9=>'September / সেপ্টেম্বর',10=>'October / অক্টোবর',
                                11=>'November / নভেম্বর',12=>'December / ডিসেম্বর',
                            ])
                            ->default(now()->month)
                            ->required(),
                        Select::make('year')
                            ->label('Year / বছর')
                            ->options(array_combine(
                                range(now()->year, now()->year - 5),
                                range(now()->year, now()->year - 5)
                            ))
                            ->default(now()->year)
                            ->required(),
                    ])
                    ->action(function (array $data, $livewire) {
                        $url = route('admin.accounts.pdf', ['month' => $data['month'], 'year' => $data['year']]);
                        $livewire->js("window.open('{$url}', '_blank')");
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->striped()
            ->paginated([25, 50, 100]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAccountTransactions::route('/'),
            'create' => Pages\CreateAccountTransaction::route('/create'),
            'edit'   => Pages\EditAccountTransaction::route('/{record}/edit'),
        ];
    }
}
