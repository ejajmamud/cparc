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
        $now       = now();
        $month     = $now->month;
        $year      = $now->year;
        $prevMonth = $now->copy()->subMonth();
        $isBn      = app()->getLocale() === 'bn';

        $cur  = AccountTransaction::monthlySummary($year, $month);
        $prev = AccountTransaction::monthlySummary($prevMonth->year, $prevMonth->month);
        $ytd  = AccountTransaction::yearlySummary($year);
        $ytdIncome  = array_sum($ytd['income']);
        $ytdExpense = array_sum($ytd['expense']);
        $ytdBalance = $ytdIncome - $ytdExpense;

        $incomeDiff  = $prev['income']  > 0 ? round((($cur['income']  - $prev['income'])  / $prev['income'])  * 100, 1) : 0;
        $expenseDiff = $prev['expense'] > 0 ? round((($cur['expense'] - $prev['expense']) / $prev['expense']) * 100, 1) : 0;

        $monthName = $now->translatedFormat('F Y');
        $net = $cur['net'];

        $bn = [
            'income'       => 'আয়',
            'expense'      => 'ব্যয়',
            'net'          => 'নিট ব্যালেন্স',
            'ytd'          => 'বার্ষিক ব্যালেন্স',
            'vs_last'      => 'গত মাসের তুলনায়',
            'surplus'      => 'উদ্বৃত্ত',
            'deficit'      => 'ঘাটতি',
            'income_lbl'   => 'আয়',
            'expense_lbl'  => 'ব্যয়',
        ];

        $incomeLabel = $isBn ? "{$bn['income']} ({$monthName})" : "Income ({$monthName})";
        $expLabel    = $isBn ? "{$bn['expense']} ({$monthName})" : "Expense ({$monthName})";
        $netLabel    = $isBn ? "{$bn['net']} ({$monthName})" : "Net Balance ({$monthName})";
        $ytdLabel    = $isBn ? "{$bn['ytd']} ({$year})" : "YTD Balance ({$year})";

        $incomeDesc = $isBn
            ? ($incomeDiff >= 0 ? "+{$incomeDiff}% {$bn['vs_last']}" : "{$incomeDiff}% {$bn['vs_last']}")
            : ($incomeDiff >= 0 ? "+{$incomeDiff}% vs last month" : "{$incomeDiff}% vs last month");

        $expDesc = $isBn
            ? ($expenseDiff <= 0 ? abs($expenseDiff)."% কম গত মাসের তুলনায়" : "+{$expenseDiff}% {$bn['vs_last']}")
            : ($expenseDiff <= 0 ? abs($expenseDiff)."% lower vs last month" : "+{$expenseDiff}% vs last month");

        $netDesc = $isBn
            ? ($net >= 0 ? $bn['surplus'] : $bn['deficit'])
            : ($net >= 0 ? 'Surplus / উদ্বৃত্ত' : 'Deficit / ঘাটতি');

        $ytdDesc = $isBn
            ? ($bn['income_lbl'] . ' ৳' . number_format($ytdIncome, 0) . ' · ' . $bn['expense_lbl'] . ' ৳' . number_format($ytdExpense, 0))
            : ('Income ৳' . number_format($ytdIncome, 0) . ' · Expense ৳' . number_format($ytdExpense, 0));

        return [
            Stat::make($incomeLabel, '৳ ' . number_format($cur['income'], 2))
                ->description($incomeDesc)
                ->descriptionIcon($incomeDiff >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($incomeDiff >= 0 ? 'success' : 'warning')
                ->chart(array_values($ytd['income'])),

            Stat::make($expLabel, '৳ ' . number_format($cur['expense'], 2))
                ->description($expDesc)
                ->descriptionIcon($expenseDiff <= 0 ? 'heroicon-m-arrow-trending-down' : 'heroicon-m-arrow-trending-up')
                ->color($expenseDiff <= 0 ? 'success' : 'danger')
                ->chart(array_values($ytd['expense'])),

            Stat::make($netLabel, '৳ ' . number_format($net, 2))
                ->description($netDesc)
                ->descriptionIcon($net >= 0 ? 'heroicon-m-check-circle' : 'heroicon-m-exclamation-circle')
                ->color($net >= 0 ? 'success' : 'danger'),

            Stat::make($ytdLabel, '৳ ' . number_format($ytdBalance, 2))
                ->description($ytdDesc)
                ->descriptionIcon('heroicon-m-calendar')
                ->color($ytdBalance >= 0 ? 'success' : 'danger'),
        ];
    }
}
