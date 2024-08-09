<?php

namespace App\Filament\Personal\Widgets;

use App\Models\User;
use App\Models\Holiday;
use App\Models\Timesheet;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class PersonalWidgetStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending Holidays', $this->getPendingHolidays(Auth::user())),
            Stat::make('Approved Holidays', $this->getApprovedHolidays(Auth::user())),
            Stat::make('Total Work',  $this->getTotalWork(Auth::user())),
            Stat::make('Total Pause',  $this->getTotalPause(Auth::user())),
        ];
    }

    protected function getPendingHolidays(User $user){
        $totalPendingHolidays=Holiday::where('user_id',$user->id)
            ->where('type','pending')->get()->count();
        return $totalPendingHolidays;
    }

    protected function getApprovedHolidays(User $user){
        $totalPendingHolidays=Holiday::where('user_id',$user->id)
            ->where('type','approved')->get()->count();
        return $totalPendingHolidays;
    }

    protected function getTotalWork(User $user){
        $timesheet=Timesheet::where('user_id',$user->id)
            ->where('type','work')->get();
        $acHour=0;
        foreach ($timesheet as $timesheet){
            $startTime=Carbon::parse($timesheet->day_in);
            $endTime=Carbon::parse($timesheet->day_out);

            $totalDuration= $endTime->diffInSeconds($startTime);
            $acHour=$acHour+$totalDuration;
        }
        $timeFormated=gmdate("H:i:s",$acHour);
        return $timeFormated;
    }

    protected function getTotalPause(User $user){
        $timesheet=Timesheet::where('user_id',$user->id)
            ->where('type','pause')->get();
        $acHour=0;
        foreach ($timesheet as $timesheet){
            $startTime=Carbon::parse($timesheet->day_in);
            $endTime=Carbon::parse($timesheet->day_out);

            $totalDuration= $endTime->diffInSeconds($startTime);
            $acHour=$acHour+$totalDuration;
        }
        $timeFormated=gmdate("H:i:s",$acHour);
        return $timeFormated;
    }
}
