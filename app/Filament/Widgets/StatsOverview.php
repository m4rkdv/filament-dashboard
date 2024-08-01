<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Holiday;
use App\Models\Timesheet;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totEmployees= User::all()->count();
        $totHolidays= Holiday::where('type', 'pending')->count();
        $totTimeSheet=Timesheet::all()->count();
        return [
            Stat::make('Total Employees', $totEmployees),
            Stat::make('Pending Holidays', $totHolidays),
            Stat::make('TimeSheets', $totTimeSheet),
            Stat::make('Unique views', '192.1k')
            ->description('32k increase')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->chart([7, 2, 10, 3, 15, 4, 17])
            ->color('success'),
        ];
    }
}
