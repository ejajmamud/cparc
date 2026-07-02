<?php

namespace App\Filament\Widgets;

use App\Models\AccountTransaction;
use Filament\Widgets\ChartWidget;

class AccountChartWidget extends ChartWidget
{
    protected static ?int $sort = 3;
    protected ?string $heading = 'Monthly Income vs Expense / মাসিক আয়-ব্যয়';
    protected int|string|array $columnSpan = 'full';
    protected ?string $maxHeight = '300px';

    public ?string $filter = null;

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
        $year = (int)($this->filter ?? now()->year);
        $data = AccountTransaction::yearlySummary($year);

        return [
            'datasets' => [
                [
                    'label'           => 'Income / আয়',
                    'data'            => array_values($data['income']),
                    'backgroundColor' => 'rgba(34,197,94,0.15)',
                    'borderColor'     => 'rgb(34,197,94)',
                    'borderWidth'     => 2,
                    'fill'            => true,
                    'tension'         => 0.4,
                ],
                [
                    'label'           => 'Expense / ব্যয়',
                    'data'            => array_values($data['expense']),
                    'backgroundColor' => 'rgba(239,68,68,0.15)',
                    'borderColor'     => 'rgb(239,68,68)',
                    'borderWidth'     => 2,
                    'fill'            => true,
                    'tension'         => 0.4,
                ],
            ],
            'labels' => ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
