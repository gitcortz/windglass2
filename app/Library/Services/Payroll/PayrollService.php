<?php

namespace App\Library\Services\Payroll;
use Carbon\Carbon;
use App\Models\Payroll;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class PayrollService implements PayrollServiceInterface
{
    const OFFICIAL_TIME_IN = '08:00:00';
    const OFFICIAL_WORK_HOUR_PER_DAY = 9;

    public function generatePayroll($year, $weekno)
    {       
        /*\DB::listen(function($query) {
        var_dump($query->sql);
        });*/

        $this->createPayrollTimeSheetsDB($year, $weekno, self::OFFICIAL_TIME_IN);
        return 1;

        //return 'Output from Generate Payroll - '.$date->toDateTimeString().' - week #'.$week;
    }

    private function getStartAndEndDate($year, $weekno) {
      $dates['start'] = date("Y-m-d", strtotime($year.'W'.str_pad($weekno, 2, 0, STR_PAD_LEFT).' -1 days'));
      $dates['end'] = date("Y-m-d", strtotime($year.'W'.str_pad($weekno, 2, 0, STR_PAD_LEFT).' +5 days'));
      return $dates;
    }

    
    private function createPayrollTimeSheetsDB($year, $weekno, $offical_time_in) {
        $date_range = $this->getStartAndEndDate($year, $weekno);
        $start = $date_range['start'];
        $end = $date_range['end'];

       
        $timesheets_result = \DB::table('timesheet_details')
            ->join('employees', 'employees.id', '=', 'timesheet_details.employee_id')
            ->select('employee_id', 'time_in', 'time_out', 'base_salary',
            DB::raw('TIME_TO_SEC(TIMEDIFF(CONCAT_WS(\' \', DATE(time_in),\''.$offical_time_in.'\'), time_in))/60 AS late_mins'),
            DB::raw('TIME_TO_SEC(TIMEDIFF(time_out, time_in))/3600 as total_hours'))
            ->whereDate('time_in', '>=', $start)
            ->whereDate('time_in', '<=', $end)
            ->orderBy('employee_id', 'ASC')
            ->orderBy('time_in', 'ASC')
            ->get();

            
        if ($timesheets_result->count() > 0) {
            $payroll_timesheets = $this->computePayroll($year, $weekno, $timesheets_result);

            if(!empty($payroll_timesheets)) {
                if (!$this->existsPayrollDB($year, $weekno)) {
                    //insert payroll
                    Payroll::insert($payroll_timesheets);
                }
                else {
                    //update payroll
                    var_dump($payroll_timesheets);
                    foreach ($payroll_timesheets as $p) {
                        DB::table('payrolls')
                            ->updateOrInsert(
                                ['employee_id' => $p["employee_id"], 
                                'year' => $p["year"], 
                                'week_no' => $p["week_no"]],
                                $p
                            );
                    }
                }
            }            
        }
       
        
    }

    private function existsPayrollDB($year, $weekno) {
        $result = \DB::table('payrolls')
                ->select('id', 'employee_id', 'week_no', 'year')
                ->where('year', '=', $year)
                ->where('week_no', '=', $weekno)
                ->count();
        return $result > 0;
    }

    private function computePayroll($year, $weekno, $timesheets_result) {
        $payroll_timesheets = [];
        $ref_employee_id = 0;
        $payroll_timesheet = null;
        $total_hours = 0;
        $total_lates = 0;

        foreach ($timesheets_result as $ts) {

            if ($ref_employee_id != $ts->employee_id) {
                if ( $payroll_timesheet != null) {
                    $payroll_timesheet->total_hours = $total_hours;
                    $payroll_timesheet->total_lates = $total_lates;  
                    $payroll_timesheet->day_rate = $ts->base_salary;
                    $payroll_timesheet->total = $ts->base_salary * $payroll_timesheet->total_days;
                    $payroll_timesheet->total_ot_amount = ($ts->base_salary/self::OFFICIAL_WORK_HOUR_PER_DAY -1)*$payroll_timesheet->total_ot_hours;
                    $payroll_timesheets[] = $payroll_timesheet->attributesToArray();
                }

                $ref_employee_id = $ts->employee_id;
                $total_hours = 0;
                $total_lates = 0;
                $payroll_timesheet = new Payroll();
                $payroll_timesheet->employee_id = $ref_employee_id;
                $payroll_timesheet->year = $year;
                $payroll_timesheet->week_no = $weekno;
                $this->initializePayroll($payroll_timesheet);
            }
            $total_hours = $total_hours + $this->computeDay($payroll_timesheet, $ts);
            $total_lates = $total_lates + ($ts->late_mins < 0 ? abs($ts->late_mins) : 0);
        }
        $payroll_timesheet->total_hours = $total_hours;
        $payroll_timesheet->total_lates = $total_lates;  
        $payroll_timesheet->day_rate = $ts->base_salary;
        $payroll_timesheet->total = $ts->base_salary * $payroll_timesheet->total_days;
        $payroll_timesheet->total_ot_amount = ($ts->base_salary/self::OFFICIAL_WORK_HOUR_PER_DAY -1)*$payroll_timesheet->total_ot_hours;
        $payroll_timesheets[] = $payroll_timesheet->attributesToArray();

        return $payroll_timesheets;
    }

    private function initializePayroll($payroll_timesheet) {
        $payroll_timesheet->sunday = 0;
        $payroll_timesheet->sunday_late = 0;
        $payroll_timesheet->monday = 0;
        $payroll_timesheet->monday_late = 0;
        $payroll_timesheet->tuesday = 0;
        $payroll_timesheet->tuesday_late = 0;
        $payroll_timesheet->wednesday = 0;
        $payroll_timesheet->wednesday_late = 0;
        $payroll_timesheet->thursday = 0;
        $payroll_timesheet->thursday_late = 0;
        $payroll_timesheet->friday = 0;
        $payroll_timesheet->friday_late = 0;
        $payroll_timesheet->saturday = 0;
        $payroll_timesheet->saturday_late = 0;
        $payroll_timesheet->payroll_status = 1;
    }

    private function computeDay($payroll_timesheet, $timesheet) {
        $dayOfWeek = date('w', strtotime($timesheet->time_in));        
        $total_hrs = $timesheet->total_hours - 1;
        $total_lates = 0;
        if ($timesheet->late_mins > 0){
            $total_hrs = $timesheet->total_hours - ($timesheet->late_mins / 60) - 1;
        } else {
            $total_lates = abs($timesheet->late_mins);
        }


        switch ($dayOfWeek) {
            case 0:
                $payroll_timesheet->sunday = $total_hrs;
                $payroll_timesheet->sunday_late = $total_lates; 
                break;    
            case 1:
                $payroll_timesheet->monday = $total_hrs;
                $payroll_timesheet->monday_late = $total_lates; 
                break;
            case 2:
                $payroll_timesheet->tuesday = $total_hrs;
                $payroll_timesheet->tuesday_late = $total_lates; 
                break;
            case 3:
                $payroll_timesheet->wednesday = $total_hrs;
                $payroll_timesheet->wednesday_late = $total_lates; 
                break;
            case 4:
                $payroll_timesheet->thursday = $total_hrs;
                $payroll_timesheet->thursday_late = $total_lates; 
                break;
            case 5:
                $payroll_timesheet->friday = $total_hrs;
                $payroll_timesheet->friday_late = $total_lates; 
                break;
            case 6:
                $payroll_timesheet->saturday = $total_hrs;
                $payroll_timesheet->saturday_late = $total_lates; 
                break;            
            default:
                break;
        }
        $payroll_timesheet->total_days = $payroll_timesheet->total_days+1;
        $payroll_timesheet->total_ot_hours = $payroll_timesheet->total_ot_hours + 
                                ($total_hrs < self::OFFICIAL_WORK_HOUR_PER_DAY ? 0  : 
                                        $total_hrs - self::OFFICIAL_WORK_HOUR_PER_DAY);
    
        return $total_hrs;
    }



    public function processCsvData($data) {
        $employee_index = config('app.upload_employee_index');
        $date_index = config('app.upload_date_index');
      
        $array = [];
        foreach ($data as $row) {
            if (is_numeric($row[$employee_index])) {
                $date_string = str_replace('/', '-', $row[$date_index]);
                $date_format = date("Ymd",strtotime($date_string));
                $index_name = $date_format."_".$row[$employee_index];
                if (Arr::exists($array, $index_name)) {
                    $array[$index_name]->time_out = date("Y-m-d H:i:s",strtotime($date_string));
                    
                }
                else {
                    $timesheet = new Timesheet();
                    $employees = Employee::where('biometrics_id', $row[$employee_index])->get();
                    if ($employees->count() > 0) {
                      $timesheet->employee_id = $employees->first()->id;
                      $timesheet->time_in =date("Y-m-d H:i:s",strtotime($date_string));
                      $timesheet->created_at = date('Y-m-d H:i:s');
                      $timesheet->updated_at = date('Y-m-d H:i:s');
                      $array[$index_name] = $timesheet;                      
                   }
                }
            }            
        }
        
        $array_timesshet = [];
        foreach ($array as $key => $value) {
           $array_timesshet[] = $value->attributesToArray();
        }

        Timesheet::insert($array_timesshet);
      
    }

}