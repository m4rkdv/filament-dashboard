<?php

namespace App\Filament\Resources\HolidayResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Mail\HolidayApproved;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\HolidayResource;

class EditHoliday extends EditRecord
{
    protected static string $resource = HolidayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data):Model{
        $record->update($data);

        //send email if approved
        if ($record->type==='approved'){
            $user= User::find($record->user_id);
            $data=array(
                'name'=>$user->name,
                'email'=>$user->email,
                'day'=>$record->day
            );
            Mail::to($user)->send(new HolidayApproved($data));
        }
        return $record;
    }
}
