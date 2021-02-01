<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ScheduleExport;
use Carbon\Carbon;

class ExportController extends Controller
{
    public function importExport()
    {
       return view('welcome');
    }
   
    public static function exportFile() 
    {
        $current = Carbon::now();
        return Excel::store(new ScheduleExport, 'schedule/users-list-'.$current.'.csv');
    }  
}