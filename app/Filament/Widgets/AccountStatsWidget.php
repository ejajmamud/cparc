<?php

namespace App\Filament\Widgets;

use App\Models\AccountTransaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AccountStatsWidget extends BaseWidget
{
    protected static ?int $sort = 2;

    protected function getStats(): array
    {
        $now      = now();
        $month    = $now->month;
        $year     = $now->year;
        $prevMonth = $now->copy()->subMonth();

        $cur  = AccountTransaction::monthlySummary($year, $month);
        $prev = AccountTransaction::monthlySummary($prevMonth->year, $prevMonth->month);
        $ytd  = AccountTransaction::yearlySummary($year);
        $ytdIncome  = array_sum($ytd['income']);
        $ytdExpense = array_sum($ytd['expense']);
        $ytdBalance = $ytdIncome - $ytdExpense;

        $incomeDiff  = $prev['income']  > 0 ? round((($cur['income']  - $prev['income'])  / $prev['income'])  * 100, 1) : 0;
        $expenseDiff = $prev['expense'] > 0 ? round((($cur['expense'] - $prev['expense']) / $prev['expense']) * 100, 1) : 0;

        $monthName = $now->format('F Y');
        $net = $cur['net'];

        return [
            Stat::make("Income ({$monthName})", '৳ ' . number_format($cur['income'], 2))
                ->description($incomeDiff >= 0 ? "+{$incomeDiff}% vs last month" : "{$incomeDiff}% vs last month")
                ->descriptionIcon($incomeDiff >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($incomeDiff >= 0 ? 'success' : 'warning')
                ->chart(array_values($ytd['income'])),

            Stat::make("Expense ({$monthName})", '৳ ' . number_format($cur['expense'], 2))
                ->description($expenseDiff <= 0 ? abs($expenseDiff)."% lower vs last month" : "+{$expenseDiff}% vs last month")
                ->descriptionIcon($expenseDiff <= 0 ? 'heroicon-m-arrow-trending-down' : 'heroicon-m-arrow-trending-up')
                ->color($expenseDiff <= 0 ? 'success' : 'danger')
                ->chart(array_values($ytd['expense'])),

            Stat::make("Net Balance ({$monthName})", '৳ ' . number_format($net, 2))
                ->description($net >= 0 ? 'Surplus / উদ্বৃত্ত' : 'Deficit / ঘাটতি')
                ->descriptionIcon($net >= 0 ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-circle')
                ->color($net >= 0 ? 'success' : 'danger'),

            Stat::make("YTD Balance ({$year})", '৳ ' . number_format($ytdBalance, 2))
                ->description('Income ৳' . number_format($ytdIncome,0) . ' · Expense ৳' . number_format($ytdExpense,0))
                ->descriptionIcon('heroicon-m-calendar')
                ->color($ytdBalance >= 0 ? 'success' : 'danger'),
        ];
    }
}
