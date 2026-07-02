<?php

namespace App\Filament\Widgets;

use App\Models\AccountTransaction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

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
                    ->where('month', now()->month)
                    ->where('year', now()->year)
                    ->orderByDesc('deposit_date')
            )
            ->columns([
                TextColumn::make('deposit_date')->label('Date')->date('d M Y'),
                TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->color(fn($state) => $state === 'income' ? 'success' : 'danger')
                    ->formatStateUsing(fn($state) => $state === 'income' ? '⬆ Income' : '⬇ Expense'),
                TextColumn::make('category')
                    ->label('Category')
                    ->formatStateUsing(fn($state) => AccountTransaction::categories()[$state] ?? $state),
                TextColumn::make('description')->label('Description')->placeholder('—')->limit(40),
                TextColumn::make('income_amount')
                    ->label('Income ৳')
                    ->formatStateUsing(fn($state) => $state > 0 ? '৳ ' . number_format($state, 0) : '—')
                    ->color('success')
                    ->weight('bold'),
                TextColumn::make('expense_amount')
                    ->label('Expense ৳')
                    ->formatStateUsing(fn($state) => $state > 0 ? '৳ ' . number_format($state, 0) : '—')
                    ->color('danger')
                    ->weight('bold'),
                TextColumn::make('payment_method')->label('Method')->badge()->color('gray'),
                TextColumn::make('voucher_number')->label('Voucher')->fontFamily('mono')->placeholder('—'),
            ])
            ->paginated(false);
    }
}
