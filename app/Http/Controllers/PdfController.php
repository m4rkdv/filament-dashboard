<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function TimesheetRecords (User $user){
        $timesheet=Timesheet::where('user_id',$user->id)->get();
        $pdf= Pdf::loadView('pdf.example',['timesheet'=>$timesheet]);
        return $pdf->download();
    }
}
