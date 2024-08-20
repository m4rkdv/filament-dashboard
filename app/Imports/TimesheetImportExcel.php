<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Calendar;
use App\Models\Timesheet;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TimesheetImportExcel implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row){
            $calendar_id=Calendar::where('name',$row[0])->first();
            if ($calendar_id != null){
                Timesheet::create([
                    'calendar_id'=>$calendar_id->id,
                    'user_id'=>Auth::user()->id,
                    'type'=> $row['tipo'],
                    'day_in'=> $row['hora_de_entrada'], 
                    'day_out'=> $row['hora_de_salida'],
                    'created_at'=>Carbon::now(),
                    'updated_at'=>Carbon::now(),
                 ]);
            }
        }
    }
}
