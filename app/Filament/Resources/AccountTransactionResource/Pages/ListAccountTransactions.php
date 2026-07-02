<?php

namespace App\Filament\Resources\AccountTransactionResource\Pages;

use App\Filament\Resources\AccountTransactionResource;
use App\Models\AccountTransaction;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListAccountTransactions extends ListRecords
{
    protected static string $resource = AccountTransactionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('➕ Add Entry / লেনদেন যোগ'),
        ];
    }

    public function getTabs(): array
    {
        $year = now()->year;
        $month = now()->month;
        return [
            'all' => Tab::make('All / সব')
                ->badge(AccountTransaction::where('year', $year)->count()),

            'income' => Tab::make('⬆ Income / আয়')
                ->modifyQueryUsing(fn(Builder $q) => $q->where('type', 'income'))
                ->badge(AccountTransaction::where('type','income')->where('year', $year)->count())
                ->badgeColor('success'),

            'expense' => Tab::make('⬇ Expense / ব্যয়')
                ->modifyQueryUsing(fn(Builder $q) => $q->where('type', 'expense'))
                ->badge(AccountTransaction::where('type','expense')->where('year', $year)->count())
                ->badgeColor('danger'),

            'this_month' => Tab::make('এই মাস')
                ->modifyQueryUsing(fn(Builder $q) => $q->where('year', $year)->where('month', $month)),
        ];
    }
}
