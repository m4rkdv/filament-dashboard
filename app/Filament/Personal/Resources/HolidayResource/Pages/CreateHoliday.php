<?php

namespace App\Filament\Personal\Resources\HolidayResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Mail\HolidayPending;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Personal\Resources\HolidayResource;

class CreateHoliday extends CreateRecord
{
    protected static string $resource = HolidayResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $data['type'] = 'pending';
        $dataToSend= array(
            'day'=>$data['day'],
            'name'=> User::find($data['user_id'])->name,
            'email'=> User::find($data['user_id'])->email,
        );

        $adminUser=User::find(1);
        Mail::to($adminUser)->send(new HolidayPending($dataToSend));
        return $data;
    }
}
