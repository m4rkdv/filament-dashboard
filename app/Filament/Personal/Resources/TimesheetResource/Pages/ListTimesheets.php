<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use Carbon\Carbon;
use Filament\Actions;
use App\Models\Timesheet;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Personal\Resources\TimesheetResource;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('inWork')
                ->label('Start Work')
                ->color('success')
                ->keyBindings(['command+s','ctrl+s'])
                ->action(function(){
                    $user= Auth::user();
                    $timesheet= new Timesheet();
                    $timesheet->calendar_id=1;
                    $timesheet->user_id=$user->id;
                    $timesheet->day_in=Carbon::now();
                    $timesheet->day_out=Carbon::now();
                    $timesheet->type='work';
                    $timesheet->save();
                })
                ->requiresConfirmation(),
            Action::make('inPause')
                ->label('Start Breake')
                ->color('info')
                ->requiresConfirmation(),
            
        ];
    }
}
