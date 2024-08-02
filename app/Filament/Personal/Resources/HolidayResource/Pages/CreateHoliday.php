<?php

namespace App\Filament\Personal\Resources\HolidayResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Personal\Resources\HolidayResource;

class CreateHoliday extends CreateRecord
{
    protected static string $resource = HolidayResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $data['type'] = 'pending';

        return $data;
    }
}
