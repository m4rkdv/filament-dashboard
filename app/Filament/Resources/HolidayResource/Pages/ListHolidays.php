<?php

namespace App\Filament\Resources\HolidayResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\HolidayResource;
use App\Imports\TimesheetImportExcel;
use EightyNine\ExcelImport\ExcelImportAction;

class ListHolidays extends ListRecords
{
    protected static string $resource = HolidayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExcelImportAction::make()
                ->color("info")
                ->use(TimesheetImportExcel::class),
            Actions\CreateAction::make(),
        ];
    }
}
