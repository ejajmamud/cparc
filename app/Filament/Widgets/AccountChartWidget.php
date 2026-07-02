<?php

namespace App\Filament\Widgets;

use App\Models\AccountTransaction;
use Filament\Widgets\ChartWidget;

class AccountChartWidget extends ChartWidget
{
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';
    protected ?string $maxHeight = '300px';

    public ?string $filter = null;

    public function getHeading(): string
    {
        return app()->getLocale() === 'bn'
            ? 'মাসিক আয়-ব্যয় চিত্র'
            : 'Monthly Income vs Expense';
    }

    protected function getFilters(): ?array
    {
        $years = [];
        for ($y = now()->year; $y >= now()->year - 4; $y--) {
            $years[(string)$y] = (string)$y;
        }
        return $years;
    }

    protected function getData(): array
    {
        $year  = (int)($this->filter ?? now()->year);
        $data  = AccountTransaction::yearlySummary($year);
        $isBn  = app()->getLocale() === 'bn';

        $months = $isBn
            ? ['জানু','ফেব্রু','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টে','অক্টো','নভে','ডিসে']
            : ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

        return [
            'datasets' => [
                [
                    'label'           => $isBn ? 'আয়' : 'Income',
                    'data'            => array_values($data['income']),
                    'backgroundColor' => 'rgba(34,197,94,0.15)',
                    'borderColor'     => 'rgb(34,197,94)',
                    'borderWidth'     => 2,
                    'fill'            => true,
                    'tension'         => 0.4,
                ],
                [
                    'label'           => $isBn ? 'ব্যয়' : 'Expense',
                    'data'            => array_values($data['expense']),
                    'backgroundColor' => 'rgba(239,68,68,0.15)',
                    'borderColor'     => 'rgb(239,68,68)',
                    'borderWidth'     => 2,
                    'fill'            => true,
                    'tension'         => 0.4,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
