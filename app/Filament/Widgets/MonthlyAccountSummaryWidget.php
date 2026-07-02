<?php

namespace App\Filament\Widgets;

use App\Models\AccountTransaction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class MonthlyAccountSummaryWidget extends BaseWidget
{
    protected static ?int $sort = 4;
    protected int|string|array $columnSpan = 'full';

    public function getHeading(): string
    {
        return app()->getLocale() === 'bn'
            ? 'এই মাসের লেনদেন'
            : 'This Month Transactions';
    }

    public function table(Table $table): Table
    {
        $isBn = app()->getLocale() === 'bn';

        return $table
            ->query(
                AccountTransaction::query()
                    ->where('month', now()->month)
                    ->where('year', now()->year)
                    ->orderByDesc('deposit_date')
            )
            ->columns([
                TextColumn::make('deposit_date')
                    ->label($isBn ? 'তারিখ' : 'Date')
                    ->date('d M Y'),

                TextColumn::make('type')
                    ->label($isBn ? 'ধরন' : 'Type')
                    ->badge()
                    ->color(fn($state) => $state === 'income' ? 'success' : 'danger')
                    ->formatStateUsing(fn($state) => $state === 'income'
                        ? ($isBn ? '⬆ আয়' : '⬆ Income')
                        : ($isBn ? '⬇ ব্যয়' : '⬇ Expense')),

                TextColumn::make('category')
                    ->label($isBn ? 'বিভাগ' : 'Category')
                    ->formatStateUsing(fn($state) => AccountTransaction::categories()[$state] ?? $state),

                TextColumn::make('description')
                    ->label($isBn ? 'বিবরণ' : 'Description')
                    ->placeholder('—')
                    ->limit(40),

                TextColumn::make('income_amount')
                    ->label($isBn ? 'আয় ৳' : 'Income ৳')
                    ->formatStateUsing(fn($state) => $state > 0 ? '৳ ' . number_format($state, 0) : '—')
                    ->color('success')
                    ->weight('bold'),

                TextColumn::make('expense_amount')
                    ->label($isBn ? 'ব্যয় ৳' : 'Expense ৳')
                    ->formatStateUsing(fn($state) => $state > 0 ? '৳ ' . number_format($state, 0) : '—')
                    ->color('danger')
                    ->weight('bold'),

                TextColumn::make('payment_method')
                    ->label($isBn ? 'পদ্ধতি' : 'Method')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('voucher_number')
                    ->label($isBn ? 'ভাউচার' : 'Voucher')
                    ->fontFamily('mono')
                    ->placeholder('—'),
            ])
            ->paginated(false);
    }
}
