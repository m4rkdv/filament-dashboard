<?php

namespace App\Filament\Personal\Widgets;

use App\Models\Timesheet;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\Auth;

class TimesheetChart extends ChartWidget
{
    protected static ?string $heading = 'Timesheet Chart';

    protected function getData(): array
    {
        $data = Trend::query(Timesheet::where('user_id',Auth::user()->id)->where('type','work'))
            ->dateColumn('day_in')
            ->between(
                start: now()->startOfYear(),
                end: now()->endOfYear(),
            )
            ->perMonth()
            ->count();
    
        return [
            'datasets' => [
                [
                    'label' => 'Timesheet',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => '#BFC2F1',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }
    public function getDescription(): ?string
    {
        return 'The number of working days per month.';
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
