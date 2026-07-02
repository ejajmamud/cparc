<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountTransactionResource\Pages;
use App\Models\AccountTransaction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AccountTransactionResource extends Resource
{
    protected static ?string $model = AccountTransaction::class;
    protected static \BackedEnum|string|null $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'আয়-ব্যয় / Accounts';
    protected static \UnitEnum|string|null $navigationGroup = 'Finance';
    protected static ?int $navigationSort = 1;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            Section::make('Transaction Details / লেনদেনের বিবরণ')->schema([
                Grid::make(2)->schema([
                    Select::make('type')
                        ->label('Type / ধরন')
                        ->options([
                            'income'  => '⬆ Income / আয়',
                            'expense' => '⬇ Expense / ব্যয়',
                        ])
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn($set) => $set('category', null)),

                    DatePicker::make('transaction_date')
                        ->label('Date / তারিখ')
                        ->required()
                        ->default(now()),
                ]),

                Grid::make(2)->schema([
                    Select::make('category')
                        ->label('Category / বিভাগ')
                        ->required()
                        ->options(fn($get) => $get('type') === 'expense'
                            ? AccountTransaction::expenseCategoryOptions()
                            : AccountTransaction::incomeCategoryOptions()
                        )
                        ->searchable(),

                    TextInput::make('sub_category')
                        ->label('Sub-Category / উপ-বিভাগ')
                        ->placeholder('e.g. January Salary'),
                ]),

                Grid::make(3)->schema([
                    TextInput::make('amount')
                        ->label('Amount (৳) / পরিমাণ')
                        ->numeric()
                        ->required()
                        ->prefix('৳')
                        ->minValue(0.01),

                    Select::make('payment_method')
                        ->label('Payment Method / পদ্ধতি')
                        ->options([
                            'cash'           => 'Cash / নগদ',
                            'cheque'         => 'Cheque / চেক',
                            'bank_transfer'  => 'Bank Transfer / ব্যাংক ট্রান্সফার',
                            'mobile_banking' => 'Mobile Banking / মোবাইল ব্যাংকিং',
                            'other'          => 'Other / অন্যান্য',
                        ])
                        ->default('cash')
                        ->required()
                        ->live(),

                    TextInput::make('voucher_number')
                        ->label('Voucher No. / ভাউচার নং')
                        ->placeholder('Auto-generated if empty')
                        ->unique(ignoreRecord: true),
                ]),

                Grid::make(2)->schema([
                    TextInput::make('bank_name')
                        ->label('Bank Name / ব্যাংকের নাম')
                        ->visible(fn($get) => in_array($get('payment_method'), ['cheque','bank_transfer'])),

                    TextInput::make('cheque_number')
                        ->label('Cheque No. / চেক নং')
                        ->visible(fn($get) => $get('payment_method') === 'cheque'),
                ]),
            ]),

            Section::make('Additional Info / অতিরিক্ত তথ্য')->schema([
                Grid::make(2)->schema([
                    TextInput::make('reference_number')
                        ->label('Reference No. / রেফারেন্স'),

                    TextInput::make('approved_by')
                        ->label('Approved By / অনুমোদনকারী'),
                ]),

                Textarea::make('description')
                    ->label('Description / বিবরণ')
                    ->rows(2),

                Textarea::make('remarks')
                    ->label('Remarks / মন্তব্য')
                    ->rows(2),

                FileUpload::make('attachment')
                    ->label('Attachment / সংযুক্তি')
                    ->disk('public')
                    ->directory('accounts/attachments')
                    ->acceptedFileTypes(['image/jpeg','image/png','application/pdf'])
                    ->maxSize(5120),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('voucher_number')
                    ->label('Voucher')
                    ->searchable()
                    ->copyable()
                    ->fontFamily('mono'),

                TextColumn::make('transaction_date')
                    ->label('Date / তারিখ')
                    ->date('d M Y')
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn($state) => $state === 'income' ? 'success' : 'danger')
                    ->formatStateUsing(fn($state) => $state === 'income' ? '⬆ Income' : '⬇ Expense'),

                TextColumn::make('category')
                    ->label('Category / বিভাগ')
                    ->formatStateUsing(fn($state) => AccountTransaction::incomeCategoryOptions()[$state]
                        ?? AccountTransaction::expenseCategoryOptions()[$state]
                        ?? $state)
                    ->searchable(),

                TextColumn::make('sub_category')
                    ->label('Sub-Category')
                    ->placeholder('—'),

                TextColumn::make('amount')
                    ->label('Amount / পরিমাণ')
                    ->formatStateUsing(fn($state) => '৳ ' . number_format($state, 2))
                    ->sortable()
                    ->color(fn($record) => $record->type === 'income' ? 'success' : 'danger')
                    ->weight('bold'),

                TextColumn::make('payment_method')
                    ->label('Method')
                    ->badge()
                    ->color('gray')
                    ->formatStateUsing(fn($state) => match($state) {
                        'cash'           => 'Cash',
                        'cheque'         => 'Cheque',
                        'bank_transfer'  => 'Bank Transfer',
                        'mobile_banking' => 'Mobile Banking',
                        default          => 'Other',
                    }),

                TextColumn::make('approved_by')
                    ->label('Approved By')
                    ->placeholder('—')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Entry Date')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('transaction_date', 'desc')
            ->filters([
                SelectFilter::make('type')
                    ->label('Type')
                    ->options([
                        'income'  => 'Income / আয়',
                        'expense' => 'Expense / ব্যয়',
                    ]),

                SelectFilter::make('payment_method')
                    ->label('Payment Method')
                    ->options([
                        'cash'           => 'Cash',
                        'cheque'         => 'Cheque',
                        'bank_transfer'  => 'Bank Transfer',
                        'mobile_banking' => 'Mobile Banking',
                    ]),

                Filter::make('this_month')
                    ->label('This Month / এই মাস')
                    ->query(fn(Builder $q) => $q->whereMonth('transaction_date', now()->month)->whereYear('transaction_date', now()->year))
                    ->toggle(),

                Filter::make('this_year')
                    ->label('This Year / এই বছর')
                    ->query(fn(Builder $q) => $q->whereYear('transaction_date', now()->year))
                    ->toggle(),

                Filter::make('date_range')
                    ->form([
                        DatePicker::make('from')->label('From / থেকে'),
                        DatePicker::make('until')->label('Until / পর্যন্ত'),
                    ])
                    ->query(function (Builder $q, array $data) {
                        return $q
                            ->when($data['from'], fn($q) => $q->whereDate('transaction_date', '>=', $data['from']))
                            ->when($data['until'], fn($q) => $q->whereDate('transaction_date', '<=', $data['until']));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([])
            ->striped()
            ->paginated([25, 50, 100]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAccountTransactions::route('/'),
            'create' => Pages\CreateAccountTransaction::route('/create'),
            'view'   => Pages\ViewAccountTransaction::route('/{record}'),
            'edit'   => Pages\EditAccountTransaction::route('/{record}/edit'),
        ];
    }
}
