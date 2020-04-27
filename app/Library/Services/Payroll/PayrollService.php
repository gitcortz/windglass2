<?php

namespace App\Library\Services\Payroll;
use Carbon\Carbon;
use Excel;
use DateTime;
use App\Models\Payroll;
use App\Models\EmployeeLoan;
use App\Models\EmployeeLoanTransaction;
use App\Models\TimesheetDetail;
use App\Models\Enums\LoanStatus;
use App\Models\Enums\LoanType;
use App\Models\Enums\PayrollStatus;
use App\Models\Enums\LoanTransactionType;
use App\Models\Enums\TimesheetStatus;
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

    private function updateEmployeeLoan($id, $loantype, $p) {
        $loan_payment = 0;        
        $loan_data = EmployeeLoan::find($id);
        if ($loan_data->loan_status_id != LoanStatus::Paid) {
            $loan_data->employee_id =  $p['employee_id'];
            $initial_balance = $loan_data->balance; 
            if ($loantype == LoanType::Salary){
                $loan_payment = $p['loan_payment'];
            } else if ($loantype == LoanType::SSS){
                $loan_payment = $p['sssloan_payment'];
            } else if ($loantype == LoanType::Vale){
                $loan_payment = $p['vale_payment'];
            } 
            
            $loan_data->balance = $loan_data->balance - $loan_payment;
            if ($loan_data->balance == 0)
                $loan_data->loan_status_id = LoanStatus::Paid;
            
                $loan_data->save();

            EmployeeLoanTransaction::create([
                'employee_loan_id' => $id, 
                'employee_id' => $p["employee_id"],            
                'before_amount' => $initial_balance,
                'after_amount' => $loan_data->balance,
                'loan_transaction_type' => LoanTransactionType::Payroll
            ]);
        }
    }

    public function approvePayroll($year, $weekno)
    {
        Payroll::where('week_no', '=', $weekno)
                ->where('year', '=', $year)
                ->update(['payroll_status' => PayrollStatus::Processed]);
        
        $date_range = $this->getStartAndEndDate($year, $weekno);
        $start = $date_range['start'];
        $end = $date_range['end'];

        $all = TimesheetDetail::
                whereDate('time_in', '>=', $start)
                ->whereDate('time_in', '<=', $end)
                ->where('status_id', '=', TimesheetStatus::Pending)
                ->update(['status_id' => TimesheetStatus::Approved]);
 

        $payrolls = Payroll::where('week_no', '=', $weekno)
                ->where('year', '=', $year)
                ->get();
            
        foreach ($payrolls as $p) {
            if ($p["salary_loan_id"] != null) {
                $this->updateEmployeeLoan($p["salary_loan_id"], LoanType::Salary, $p);
            }
            if ($p["vale_loan_id"] != null) {
                $this->updateEmployeeLoan($p["vale_loan_id"], LoanType::Vale, $p);
            }
            if ($p["sss_loan_id"] != null) {
                $this->updateEmployeeLoan($p["sss_loan_id"], LoanType::SSS, $p);
            }
        }

        return;
        
    }

    public function exportPayroll($year, $weekno)
    {
        $payrolls = Payroll::where('year', $year)
        ->where('week_no', $weekno)
        ->get();

            $payrollArray = []; 

            $title = $this->getStartAndEndTitle($year, $weekno);
            $payrollArray[] = ['Windglass Company'];
            $payrollArray[] = ['Employee Timesheet'];
            $payrollArray[] = [];
            $payrollArray[] = ['NO', $title,'SUN','MON','TUE','WED','THU','FRI','SAT','Days'
                            ,'Rate', 'TOTAL', 'LOAN', 'VALE/OTHERS','Company Loan', 'SSS Loan', 'OTs', 'Overtime', 'Loan Balance', 'Grand Total'];
            $idx = 1;
            foreach ($payrolls as $payroll) {
                $arr = array($idx,
                            $payroll->employee->first_name." ".$payroll->employee->last_name,
                            $this->getPayrollDayLabel($payroll, 0),
                            $this->getPayrollDayLabel($payroll, 1),
                            $this->getPayrollDayLabel($payroll, 2),
                            $this->getPayrollDayLabel($payroll, 3),
                            $this->getPayrollDayLabel($payroll, 4),
                            $this->getPayrollDayLabel($payroll, 5),
                            $this->getPayrollDayLabel($payroll, 6),
                            (double)$payroll->total_days,
                            (double)$payroll->day_rate,
                            (double)$payroll->total,
                            $payroll->total_loans,
                            (double)$payroll->vale_payment,
                            (double)$payroll->loan_payment,
                            (double)$payroll->sssloan_payment,
                            (double)$payroll->total_ot_hours,
                            (double)$payroll->total_ot_amount,
                            (double)$payroll->loan_balance,
                            (double)$payroll->grand_total,
                        );
                $payrollArray[] = $arr;
                $idx++;
            }

            $payrollArray[] = [];
            //Total
            $rowStart = 5;
            $rowEnd = $rowStart+$payrolls->count()-1;
            $payrollArray[] = ['','','','','','','','','','','',
                    '=SUM(L'.$rowStart.':L'.$rowEnd.')',
                    '',
                    '=SUM(N'.$rowStart.':N'.$rowEnd.')',
                    '=SUM(O'.$rowStart.':O'.$rowEnd.')',
                    '=SUM(P'.$rowStart.':P'.$rowEnd.')',
                    '=SUM(Q'.$rowStart.':Q'.$rowEnd.')',
                    '=SUM(R'.$rowStart.':R'.$rowEnd.')',
                    '=SUM(S'.$rowStart.':S'.$rowEnd.')',
                    '=SUM(T'.$rowStart.':T'.$rowEnd.')',
                ];
            

            // Generate and return the spreadsheet
            Excel::create('payroll', function($excel) use ($payrollArray, $title, $rowStart, $rowEnd) {
                $excel->setTitle('Payroll '.$title);
                $excel->setCreator('Laravel')->setCompany('Windglass Company');
                $excel->setDescription('employee timesheet');

                // Build the spreadsheet, passing in the payments array
                $excel->sheet('sheet1', function($sheet) use ($payrollArray, $rowStart, $rowEnd) {
                    $sheet->fromArray($payrollArray, null, 'A1', false, false);
                    $sheet->mergeCells('A1:B1');
                    $sheet->mergeCells('A2:B2');
                    $sheet->getStyle('B4:T4')->applyFromArray(array(
                        'font' => array(
                            'name'      =>  'Calibri',
                            'size'      =>  12,
                            'bold'      =>  true,                        
                        )
                    ));
                    $sheet->getStyle('J'.$rowStart.':J'.$rowEnd)->applyFromArray(array(
                        'font' => array(
                            'color' => array('rgb' => 'FF0000'),
                            'bold'      =>  true,   
                        )
                    ));
                    $sheet->getStyle('N'.$rowStart.':N'.$rowEnd)->applyFromArray(array(
                        'font' => array(
                            'color' => array('rgb' => 'FF0000'),
                            'bold'      =>  true,   
                        )
                    ));
                    $sheet->getStyle('O'.$rowStart.':O'.$rowEnd)->applyFromArray(array(
                        'font' => array(
                            'color' => array('rgb' => 'FF0000'),
                            'bold'      =>  true,   
                        )
                    ));
                    $sheet->getStyle('P'.$rowStart.':P'.$rowEnd)->applyFromArray(array(
                        'font' => array(
                            'color' => array('rgb' => 'FF0000'),
                            'bold'      =>  true,   
                        )
                    ));                  
                    $sheet->getStyle('S'.$rowStart.':S'.$rowEnd)->applyFromArray(array(
                        'font' => array(
                            'color' => array('rgb' => 'FF0000'),
                            'bold'      =>  true,   
                        )
                    ));
                    $sheet->getStyle('T'.$rowStart.':T'.$rowEnd)->applyFromArray(array(
                        'font' => array(
                            'bold'      =>  true,   
                        )
                    ));
                });

            })->download('xlsx');
    }

    public function loansReportData($year, $weekno) {          
        $loanreport = Payroll::where('year', $year)
                ->where('week_no', $weekno)
                ->where('payroll_status', 2)
                ->join('employees as e', 'payrolls.employee_id', '=', 'e.id')
                ->leftJoin('employee_loans as vl', 'payrolls.vale_loan_id', '=', 'vl.id')
                ->leftJoin('employee_loans as sl', 'payrolls.sss_loan_id', '=', 'sl.id')
                ->leftJoin('employee_loans as el', 'payrolls.salary_loan_id', '=', 'el.id')
                ->selectRaw('payrolls.id,
                        CONCAT(e.first_name, \' \', e.last_name) as employeename,
                        (CASE WHEN payrolls.loan_payment IS NULL THEN 0 ELSE payrolls.loan_payment END) as loan_payment,
                        (CASE WHEN payrolls.vale_payment IS NULL THEN 0 ELSE payrolls.vale_payment END) as vale_payment,
                        (CASE WHEN payrolls.sssloan_payment IS NULL THEN 0 ELSE payrolls.sssloan_payment END) as sssloan_payment,
                        (CASE WHEN payrolls.loan_payment IS NULL THEN 0 ELSE payrolls.loan_payment END + 
                        CASE WHEN payrolls.vale_payment IS NULL THEN 0 ELSE payrolls.vale_payment END + 
                        CASE WHEN payrolls.sssloan_payment IS NULL THEN 0 ELSE payrolls.sssloan_payment END)
                         as total_loan_payment,
                        (CASE WHEN vl.balance IS NULL THEN 0 ELSE vl.balance END) as vale_balance,
                        (CASE WHEN el.balance IS NULL THEN 0 ELSE el.balance END) as emp_balance,
                        (CASE WHEN sl.balance IS NULL THEN 0 ELSE sl.balance END) as sss_balance
                        ');

        return $loanreport;
    }

    public function exportLoanReport($year, $weekno)
    {
        $report = $this->loansReportData($year, $weekno)->get();

            $excelArray = []; 

            $title = $this->getStartAndEndTitle($year, $weekno);
            $excelArray[] = ['Windglass Company'];
            $excelArray[] = ['Employee Loan Report'];
            $excelArray[] = [];
            $excelArray[] = ['NO', $title,'COMPANY LOAN Balance','VALE / OTHERS','SSS Loan Balance',
                                    'COMPANY LOAN Deduction','VALE / OTHERS Deduction','SSS Loan Deduction','Total Deduction'];
            $idx = 1;    
            foreach ($report as $data) {
                $arr = array($idx,
                            $data->employeename,
                            $data->emp_balance,
                            $data->vale_balance,
                            $data->sss_balance,
                            $data->loan_payment,
                            $data->vale_payment,
                            $data->sssloan_payment,                            
                            $data->total_loan_payment,
                        );
                $excelArray[] = $arr;
                $idx++;
            }

            $excelArray[] = [];
            //Total
            $rowStart = 5;
            $rowEnd = $rowStart+$report->count()-1;           

            // Generate and return the spreadsheet
            Excel::create('loanreport', function($excel) use ($excelArray, $title, $rowStart, $rowEnd) {
                $excel->setTitle('Loan Report '.$title);
                $excel->setCreator('Laravel')->setCompany('Windglass Company');
                $excel->setDescription('employee loan report');

                
                // Build the spreadsheet, passing in the payments array
                $excel->sheet('sheet1', function($sheet) use ($excelArray, $rowStart, $rowEnd) {
                    $sheet->fromArray($excelArray, null, 'A1', false, false);
                    $sheet->mergeCells('A1:B1');
                    $sheet->mergeCells('A2:B2');
                    $sheet->getStyle('B4:I4')->applyFromArray(array(
                        'font' => array(
                            'name'      =>  'Calibri',
                            'size'      =>  10,
                            'bold'      =>  true,                        
                        ),
                    ))->getAlignment()->setWrapText(true)
                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                    $sheet->setWidth(array(
                        'B'     =>  23,
                        'C'     =>  17,
                        'D'     =>  17,
                        'E'     =>  17,
                        'F'     =>  17,
                        'G'     =>  17,
                        'H'     =>  17,
                        'I'     =>  17,
                    ));

                    $sheet->getStyle('C'.$rowStart.':E'.$rowEnd)
                    ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('F'.$rowStart.':H'.$rowEnd)->applyFromArray(array(
                        'font' => array(
                            'color' => array('rgb' => 'FF0000'),
                        )
                    ))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $sheet->getStyle('I'.$rowStart.':I'.$rowEnd)->applyFromArray(array(
                        'font' => array(
                            'color' => array('rgb' => 'FF0000'),
                            'bold'      =>  true,   
                        )
                    ))->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                });

            })->download('xlsx');
    }


    public function getStartAndEndDate($year, $weekno) {
      $dates['start'] = date("Y-m-d", strtotime($year.'W'.str_pad($weekno, 2, 0, STR_PAD_LEFT).' -1 days'));
      $dates['end'] = date("Y-m-d", strtotime($year.'W'.str_pad($weekno, 2, 0, STR_PAD_LEFT).' +5 days'));
      return $dates;
    }

    private function getPayrollDayLabel($payroll, $index) {
        switch($index) {
            case 0:
                return $payroll->sunday == 0 ? "A" : 
                        ($payroll->sunday < 4 ? "HD" : 
                        ($payroll->sunday_late > 0 ? "L" :"x")); 
            case 1:
                return $payroll->monday == 0 ? "A" : 
                        ($payroll->monday < 4 ? "HD" : 
                        ($payroll->monday_late > 0 ? "L" :"x")); 
            case 2:
                return $payroll->tuesday == 0 ? "A" : 
                        ($payroll->tuesday < 4 ? "HD" : 
                        ($payroll->tuesday_late > 0 ? "L" :"x")); 
            case 3:
                return $payroll->wednesday == 0 ? "A" : 
                        ($payroll->wednesday < 4 ? "HD" : 
                        ($payroll->wednesday_late > 0 ? "L" :"x")); 
            case 4:
                return $payroll->thursday == 0 ? "A" : 
                        ($payroll->thursday < 4 ? "HD" : 
                        ($payroll->thursday_late > 0 ? "L" :"x")); 
            case 5:
                return $payroll->friday == 0 ? "A" : 
                        ($payroll->friday < 4 ? "HD" : 
                        ($payroll->friday_late > 0 ? "L" :"x")); 
            case 6:
                return $payroll->saturday == 0 ? "A" : 
                        ($payroll->saturday < 4 ? "HD" : 
                        ($payroll->saturday_late > 0 ? "L" :"x")); 
            default:
                return "";                            
        }
    }
    public function getStartAndEndTitle($year, $weekno) {
        $start = Carbon::parse(date("Y-m-d", strtotime($year.'W'.str_pad($weekno, 2, 0, STR_PAD_LEFT).' -1 days')));
        $end = Carbon::parse(date("Y-m-d", strtotime($year.'W'.str_pad($weekno, 2, 0, STR_PAD_LEFT).' +5 days')));
        $title = $start->format('M d');

        if ($start->month == $end->month && $start->year == $end->year ) {
            $title = $title.'-'.$end->format('d Y');
        } 
        else if ($start->month != $end->month && $start->year == $end->year) {
            $title = $title.'-'.$end->format('M d Y');
        }
        else {
            $title = $title.' '.$start->format('Y').'-'.$end->format('M d Y');
        }
        
        return $title;
      }

    
    private function createPayrollTimeSheetsDB($year, $weekno, $offical_time_in) {
        $date_range = $this->getStartAndEndDate($year, $weekno);
        $start = $date_range['start'];
        $end = $date_range['end'];

       
        $timesheets_result = \DB::table('timesheet_details')
            ->join('employees', 'employees.id', '=', 'timesheet_details.employee_id')
            ->select('employee_id', 'time_in', 'time_out', 'base_salary',
            DB::raw('TIME_TO_SEC(TIMEDIFF(CONCAT_WS(\' \', DATE(time_in),\''.$offical_time_in.'\'), time_in))/60 AS late_mins'),
            DB::raw('TIME_TO_SEC(TIMEDIFF(CASE WHEN HOUR(time_out) > 20 THEN DATE_FORMAT(time_out, \'%Y-%m-%d 20:0:0\') ELSE time_out END, time_in))/3600 as total_hours'))
            ->whereDate('time_in', '>=', $start)
            ->whereDate('time_in', '<=', $end)
            ->orderBy('employee_id', 'ASC')
            ->orderBy('time_in', 'ASC')
            ->get();

            
        if ($timesheets_result->count() > 0) {
            $payroll_timesheets = $this->computePayroll($year, $weekno, $timesheets_result);
            $payroll_timesheets = $this->computePayrollLoans($payroll_timesheets);
            $payroll_timesheets = $this->computeGrandTotal($payroll_timesheets);

            //var_dump($payroll_timesheets);
            //return;

            if(!empty($payroll_timesheets)) {
                if (!$this->existsPayrollDB($year, $weekno)) {
                    //insert payroll
                    Payroll::insert($payroll_timesheets);
                }
                else {
                    //update payroll
                    //var_dump($payroll_timesheets);
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

    private function computePayrollLoans($payroll_timesheets) {
      
        $loans_result = \DB::table('employee_loans')
            ->select('id', 'employee_id', 'loan_amount', 'balance', 'loan_type_id')
            ->where('loan_status_id', LoanStatus::Loaned)
            ->where('balance', '>', 0)
            ->orderBy('employee_id', 'ASC')
            ->orderBy('loan_type_id', 'ASC')
            ->get();

    
        if ($loans_result->count() > 0) {
            foreach ($payroll_timesheets as &$pt) {
                $loans = $loans_result->filter(function ($item) use ($pt) {
                            return $item->employee_id == $pt["employee_id"];
                        })->values();
                        
                if ($loans->count() > 0){
                    $loan_total = 0;
                    $loan_payment = 0;
                    foreach ($loans as $loan) {
                        if ($loan->loan_type_id == LoanType::Vale){
                            $vale_payment = $loan->balance;
                            $pt["vale_loan_id"] = $loan->id;
                            $pt["vale_payment"] = $vale_payment;
                            $loan_payment += $vale_payment;                            
                        }
                        else if ($loan->loan_type_id == LoanType::Salary) {
                            $salaryloan_payment = $loan->balance;
                            $pt["salary_loan_id"] = $loan->id;
                            if ($salaryloan_payment > 500)
                                $salaryloan_payment = 500;
                            $pt["loan_payment"] = $salaryloan_payment;
                            $loan_payment += $salaryloan_payment;                            
                        }
                        else if ($loan->loan_type_id == LoanType::SSS) {
                            $sss_payment = $loan->loan_amount / 24;
                            $pt["sss_loan_id"] = $loan->id;
                            $pt["sssloan_payment"] = $sss_payment;    
                            $loan_payment += $sss_payment;
                        }                                    
                        $loan_total = $loan_total + $loan->balance;
                    }                    
                    $pt["total_loans"] = $loan_total;
                    $pt["loan_balance"] = $loan_total - $loan_payment; 
                }
            }
        }
                    
        return $payroll_timesheets;
    }

    private function computeGrandTotal($payroll_timesheets) {
      
        foreach ($payroll_timesheets as &$pt) {
            $vale_payment = !array_key_exists('vale_payment', $pt) ? 0 : $pt["vale_payment"];
            $sss_payment = !array_key_exists('sssloan_payment', $pt) ? 0 : $pt["sssloan_payment"];
            $salary_payment = !array_key_exists('loan_payment', $pt) ? 0 : $pt["loan_payment"];

            $pt["grand_total"] = $pt["total"] + $pt["total_ot_amount"] - ($vale_payment + $sss_payment + $salary_payment);
        }
                    
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
        //$payroll_timesheet->total_loans = 0;
        //$payroll_timesheet->vale_payment = 0;
        //$payroll_timesheet->loan_payment = 0;
        //$payroll_timesheet->sss_payment = 0;
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