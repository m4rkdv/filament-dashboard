<?php

namespace App\Filament\Resources\TimesheetResource\Pages;

use Filament\Actions;
use App\Imports\TimesheetImportExcel;
use EightyNine\ExcelImport\ExcelImportAction;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TimesheetResource;


class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

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
