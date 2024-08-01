<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;



class UserChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';
    public ?string $filter = 'week';

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $this->dataChart(),
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function dataChart()
    {
        return [0, 10, 5, 2, 21, 32, 45, 74, 65, 45, 77, 89];
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }
}
