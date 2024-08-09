<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use Carbon\Carbon;
use Filament\Actions;
use App\Models\Timesheet;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Personal\Resources\TimesheetResource;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        $lastTimesheet= Timesheet::where('user_id',Auth::user()->id)->orderBy('id','desc')->first();
        if ($lastTimesheet==null){
            return[
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
                    $timesheet->type='work';
                    $timesheet->save();
                })
                ->requiresConfirmation(),
            ];
        };
        return [
            Actions\CreateAction::make(),
            Action::make('inWork')
                ->label('Start Work')
                ->color('success')
                ->keyBindings(['command+s','ctrl+s'])
                ->visible(!$lastTimesheet->day_out==null)
                ->disabled($lastTimesheet->day_out==null)
                ->action(function(){
                    $user= Auth::user();
                    $timesheet= new Timesheet();
                    $timesheet->calendar_id=1;
                    $timesheet->user_id=$user->id;
                    $timesheet->day_in=Carbon::now();
                   // $timesheet->day_out=Carbon::now();
                    $timesheet->type='work';
                    $timesheet->save();
                    Notification::make()
                    ->title('Workday has started!')
                    ->success()
                    ->color('success')
                    ->send();
                })
                ->requiresConfirmation(),
            Action::make('stopWork')
                ->label('End Work')
                ->color('success')
                ->visible($lastTimesheet->day_out==null &&  $lastTimesheet->type!='pause')
                ->disabled(!$lastTimesheet->day_out==null)
                ->action(function() use($lastTimesheet){
                    $lastTimesheet->day_out=Carbon::now();
                    $lastTimesheet->save();
                    Notification::make()
                    ->title('Workday has ended!')
                    ->success()
                    ->color('success')
                    ->send();
                })
                ->requiresConfirmation(),
            Action::make('inPause')
                ->label('Start Breake')
                ->color('info')
                ->requiresConfirmation()
                ->visible($lastTimesheet->day_out==null &&  $lastTimesheet->type!='pause')
                ->disabled(!$lastTimesheet->day_out==null)
                ->action(function()use($lastTimesheet){
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();
                    $timesheet = new Timesheet();
                    $timesheet->calendar_id=1;
                    $timesheet->user_id= Auth::user()->id;
                    $timesheet->day_in=Carbon::now();
                    $timesheet->type ='pause';
                    $timesheet->save();
                    Notification::make()
                    ->title('Pause has started!')
                    ->info()
                    ->color('info')
                    ->send();
                }),
            Action::make('stopPause')
                ->label('End Breake')
                ->color('info')
                ->requiresConfirmation()
                ->visible($lastTimesheet->day_out==null &&  $lastTimesheet->type=='pause')
                ->disabled(!$lastTimesheet->day_out==null)
                ->action(function()use($lastTimesheet){
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();
                    $timesheet = new Timesheet();
                    $timesheet->calendar_id=1;
                    $timesheet->user_id= Auth::user()->id;
                    $timesheet->day_in=Carbon::now();
                    $timesheet->type ='work';
                    $timesheet->save();
                    Notification::make()
                    ->title('Pause has ended.')
                    ->info()
                    ->color('info')
                    ->send();
                }),  
        ];
    }
}
