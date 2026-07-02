<?php

namespace App\Filament\Resources\AccountTransactionResource\Pages;

use App\Filament\Resources\AccountTransactionResource;
use App\Models\AccountTransaction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListAccountTransactions extends ListRecords
{
    protected static string $resource = AccountTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Add Transaction / লেনদেন যোগ করুন'),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All / সব')
                ->badge(AccountTransaction::whereYear('transaction_date', now()->year)->count()),

            'income' => Tab::make('⬆ Income / আয়')
                ->modifyQueryUsing(fn(Builder $q) => $q->where('type', 'income'))
                ->badge(AccountTransaction::where('type','income')->whereYear('transaction_date', now()->year)->count())
                ->badgeColor('success'),

            'expense' => Tab::make('⬇ Expense / ব্যয়')
                ->modifyQueryUsing(fn(Builder $q) => $q->where('type', 'expense'))
                ->badge(AccountTransaction::where('type','expense')->whereYear('transaction_date', now()->year)->count())
                ->badgeColor('danger'),

            'this_month' => Tab::make('This Month / এই মাস')
                ->modifyQueryUsing(fn(Builder $q) => $q
                    ->whereMonth('transaction_date', now()->month)
                    ->whereYear('transaction_date', now()->year)),
        ];
    }
}
