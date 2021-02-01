<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Carbon\Carbon;

class ScheduleExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function findSpecificDaysInMonth($mon)
    {
        $dateDay = Carbon::create(2021, $mon);
        $year = $dateDay->year;
        $month = $dateDay->month;
        $days = $dateDay->daysInMonth;

        /**
         * =============================================================================================================================
         *
         * Create an array with all Tuesdays and Thursdays in specific month.
         */
        foreach (range(1, $days) as $day) {
            $date = Carbon::createFromDate($year, $month, $day);
            if ($date->isTuesday()===true || $date->isThursday()) {
                $tueThu[]=($date->format('d-M-D-Y'));
            } 
        }

        /**
         * =============================================================================================================================
         *
         * In this section I'm finding the last day of the month and appending it to an array of days detected in previous foreach,
         *  we are appending only if that day is not Tue or Thu.
         */
        $date = Carbon::createFromDate($year, $month, $day);
        if ($date->endOfMonth()->format('d-M-D-Y') !== last($tueThu) && $date->endOfMonth() == $date->isWeekday()) {
            $tueThu[]=($date->format('d-M-D-Y'));
        } else if ($date->endOfMonth()->format('d-M-D-Y') !== last($tueThu) && $date->endOfMonth()->subDays(1) == $date->isWeekday()) {
            $tueThu[]=($date->format('d-M-D-Y'));
        } else if ($date->endOfMonth()->format('d-M-D-Y') !== last($tueThu) && $date->endOfMonth()->subDays(2) == $date->isWeekday()) {
            $tueThu[]=($date->format('d-M-D-Y'));
        } 

        return $tueThu;
    }

    public function detectCurrentMonth()
    {   
        /**
         * Detects current month
         * 
         * @return int
         */
        $month = Carbon::now();
        return $month->month;
    }

    public function collection()
    {
        /**
         * =============================================================================================================================
         * 
         * I have added this section as a static option becouse for lighter version of this code. If we need more dynamic aproach with 
         * more complex tasks then mybe we will need to create an DB table for this section.
         */
        $vac    = 'Vacuuming';
        $winCle = 'Window cleaning';
        $refCle = 'Refrigerator cleaning';

        $schedule[] = [
            'Date'          => 'Date',
            'Activities'    => 'Activities to be performed',
            'Time'          => 'Total Time'
        ];

        /**
         * =============================================================================================================================
         * 
         * Creating an array with specific days in the next 3 months
         */
        for ($i=1; $i<4; $i++) {
            $days[] = $this->findSpecificDaysInMonth($this->detectCurrentMonth()+$i);
        }

        /**
         * =============================================================================================================================
         *
         *  Creating an array with specific day, activites and time spend for the activites in that day for previosly defined days.
         */
        for ($i = 0; $i < 3; $i++) {
            $tmp = count($days[$i]);
            for ($j = 0; $j < $tmp; $j++ ) {

                if ($j == 0) {
                    $schedule[] = [
                        'Date'     => $days[$i][$j],
                        'Activities'    => $vac.', '.$refCle,
                        'Time' => date('H:i', mktime(0,71))
                    ];

                } else if ($j == $tmp-1) {

                    $dayName = explode('-', $days[$i][$j]);

                    if ($dayName[2] == 'Tue' || $dayName[2] == 'Thu') {
                       
                        $schedule[] = [
                            'Date'          => $days[$i][$j],
                            'Activities'    => $vac.', '.$winCle,
                            'Time'          => date('H:i', mktime(0,56))
                        ];

                    } else {
                       
                        $schedule[] = [
                            'Date'          => $days[$i][$j],
                            'Activities'    => $winCle,
                            'Time'          => date('H:i', mktime(0,56))
                        ];

                    }
                } else {
                    
                    $schedule[] = [
                        'Date'          => $days[$i][$j],
                        'Activities'    => $vac,
                        'Time'          => date('H:i', mktime(0,21))
                    ];

                }
            }
        }

        return collect($schedule);
    }   
}
