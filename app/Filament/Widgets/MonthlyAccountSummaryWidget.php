<?php

namespace App\Filament\Widgets;

use App\Models\AccountTransaction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class MonthlyAccountSummaryWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected static ?string $heading = 'This Month Transactions / এই মাসের লেনদেন';
    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                AccountTransaction::query()
                    ->whereMonth('transaction_date', now()->month)
                    ->whereYear('transaction_date', now()->year)
                    ->orderByDesc('transaction_date')
            )
            ->columns([
                TextColumn::make('transaction_date')->label('Date')->date('d M Y'),
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn($state) => $state === 'income' ? 'success' : 'danger')
                    ->formatStateUsing(fn($state) => $state === 'income' ? '⬆ Income' : '⬇ Expense'),
                TextColumn::make('category')
                    ->label('Category')
                    ->formatStateUsing(fn($state) => AccountTransaction::incomeCategoryOptions()[$state]
                        ?? AccountTransaction::expenseCategoryOptions()[$state]
                        ?? $state),
                TextColumn::make('description')->label('Description')->placeholder('—')->limit(40),
                TextColumn::make('amount')
                    ->label('Amount')
                    ->formatStateUsing(fn($state) => '৳ ' . number_format($state, 2))
                    ->color(fn($record) => $record->type === 'income' ? 'success' : 'danger')
                    ->weight('bold'),
                TextColumn::make('payment_method')->label('Method')->badge()->color('gray'),
                TextColumn::make('voucher_number')->label('Voucher')->fontFamily('mono'),
            ])
            ->paginated(false);
    }
}
