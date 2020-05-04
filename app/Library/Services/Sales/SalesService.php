<?php

namespace App\Library\Services\Sales;
use Carbon\Carbon;
use Excel;
use DateTime;
use App\Models\Order;
use App\Models\Branch;
use App\Models\Enums\PaymentStatus;
use App\Models\Enums\OrderStatus;
use PHPExcel_Style_Border;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class SalesService implements SalesServiceInterface
{
    private $daily_sales_product_summary_total_idx;
    private $daily_sales_data_start_idx;
    private $daily_sales_data_end_idx;
    private $foo;
    
    public function salesExcelReport($start, $end, $branch_id)
    {
        $report = $this->get_sales_data($start, $end, $branch_id);
        

        $branch = Branch::find($branch_id);
        $report_date = Carbon::parse($start)->format('Y-m-d');
        $title = "Daily Sales Report ".$report_date." - ".$branch->name;        
        $salesArray[] = ['Windglass Marketing Inc'];
        $salesArray[] = [$branch->name];
        $salesArray[] = ['Daily Sales Report'];
        $salesArray[] = [$report_date];
        $salesArray[] = [];
        $salesArray[] = ['DATE', '#', 'CUSTOMER NAME', 'ADDRESS','PRODUCT', 'QTY', 'PRICE','DISCOUNT','TOTAL', 'RIDER',
                        'CREATED BY','LAST UPDATED BY','STATUS'];

        $idx = 1;
        foreach ($report as $r) {
            $line_total = $r->quantity * ($r->unit_price - $r->discount);
            $line_total = ($r->payment_status_id == 30) ? $line_total * -1.0 : $line_total;

            $arr = array(
                        Carbon::parse($r->order_date)->format('Y-m-d'),
                        $r->id,
                        $r->customer_name,
                        $r->address,
                        $r->product_name,
                        $r->quantity,
                        (double)$r->unit_price,
                        (double)$r->discount,
                        (double)$line_total,
                        $r->riderfname.' '.$r->riderlname,
                        $r->createdbyname,
                        $r->updatedbyname,
                        PaymentStatus::getName($r->payment_status_id)
                    );
            $salesArray[] = $arr;
            $idx++;
        }

        $rowStart = 7;
        $rowEnd = $rowStart+$report->count()-1;
        $this->daily_sales_data_start_idx = $rowStart;
        $this->daily_sales_data_end_idx = $rowEnd+1;
        $salesArray[] = ['','','','','GRAND TOTAL',
            '=SUM(F'.$rowStart.':F'.$rowEnd.')',
            '=SUM(G'.$rowStart.':G'.$rowEnd.')',
            '=SUM(H'.$rowStart.':H'.$rowEnd.')',
            '=SUM(I'.$rowStart.':I'.$rowEnd.')',            
        ];


        $salesArray = array_merge($salesArray, $this->export_daily_sales_summary_by_product($start, $end, $branch_id, $rowEnd+1));
        $salesArray = array_merge($salesArray, $this->export_daily_sales_cash_flow($start, $end, $branch_id));

        // Generate and return the spreadsheet
        Excel::create('dailysales', function($excel) use ($salesArray, $title, $rowStart, $rowEnd) {
            $excel->setTitle($title);
            $excel->setCreator('Laravel')->setCompany('Windglass Company');
            $excel->setDescription($title);

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($salesArray, $rowStart, $rowEnd) {
                $sheet->fromArray($salesArray, null, 'A1', false, false);
                $this->updateExportDailySalesExcelStyles($sheet, $rowEnd);
                
            });

        })->download('xlsx');
    }


    private function updateExportDailySalesExcelStyles($sheet, $rowEnd) {
        $totalRowIndex = $rowEnd + 1;
        $summaryRowIndex = $rowEnd + 2;
        
        $cash_flow_idx = $this->daily_sales_product_summary_total_idx+1;
        $total_sales_idx = $cash_flow_idx+4;
        $net_sales_idx = $total_sales_idx+2;
        $cash_on_hand_idx = $net_sales_idx+3;

        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('A3:D3');
        $sheet->mergeCells('A4:D4');
        $sheet->mergeCells('A'.$summaryRowIndex.':D'.$summaryRowIndex);

        //format
        
        $sheet->setColumnFormat(array('G'.$this->daily_sales_data_start_idx.':I'.$this->daily_sales_data_end_idx.'' => '0.00'));

        $sheet->setColumnFormat(array('B'.($cash_flow_idx+2).':B'.($cash_flow_idx+11).'' => '0.00'));

        

        //borders
            $sheet->getStyle('A'.$totalRowIndex.':M'.$totalRowIndex)->applyFromArray(array(
                'borders' => array(
                    'top' => [
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                )
            ));
            $sheet->getStyle('A'.$this->daily_sales_product_summary_total_idx.':M'.$this->daily_sales_product_summary_total_idx)->applyFromArray(array(
                'borders' => array(
                    'top' => [
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                )
            ));

           
            $sheet->getStyle('A'.$total_sales_idx.':B'.$total_sales_idx)->applyFromArray(array(
                'borders' => array(
                    'top' => [
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                )
            ));
            $sheet->getStyle('A'.$net_sales_idx.':B'.$net_sales_idx)->applyFromArray(array(
                'borders' => array(
                    'top' => [
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                )
            ));
            $sheet->getStyle('A'.$cash_on_hand_idx.':B'.$cash_on_hand_idx)->applyFromArray(array(
                'borders' => array(
                    'top' => [
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                )
            ));

        
    }
    
    function get_sales_data($start, $end, $branch_id)
    {
        $report = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('stocks', 'stocks.id', '=', 'order_items.stock_id')
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->leftJoin('users as createdby', 'createdby.id', '=', 'orders.createdby_id')
            ->leftJoin('users as updatedby', 'updatedby.id', '=', 'orders.lastupdatedby_id')
            ->leftJoin('employees as riders', 'riders.id', '=', 'orders.rider_id')
            ->select('order_date', 'orders.id', 'customers.name as customer_name', 'customers.address as address', 
                    'riders.first_name as riderfname', 'riders.last_name as riderlname', 'products.name as product_name', 
                    'createdby.name as createdbyname', 'updatedby.name as updatedbyname', 
                    'order_items.quantity', 'order_items.unit_price', 
                    'order_items.discount', 'orders.payment_status_id')
            ->where('order_date', '>=', $start)
            ->where('order_date', '<=', $end)
            ->where('orders.branch_id', '=', $branch_id)
            ->where('orders.order_status_id', '=', (int)OrderStatus::Completed)
            ->get();
        return $report;
    }
    
    function export_daily_sales_summary_by_product($start, $end, $branch_id, $rowIdx)
    {
        $summaryArray[] = ['SUMMARY BY PRODUCT']; 
        
        $summary = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('stocks', 'stocks.id', '=', 'order_items.stock_id')
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->select('order_items.stock_id', 'products.name as product_name',
                    DB::raw("SUM(order_items.quantity) as quantity"))
            ->where('order_date', '>=', $start)
            ->where('order_date', '<=', $end)
            ->where('orders.branch_id', '=', $branch_id)
            ->where('orders.order_status_id', '=', (int)OrderStatus::Completed)
            ->groupBy('order_items.stock_id', 'products.name')
            ->get();

            foreach ($summary as $r) {
                $arr = array('','','','',
                            $r->product_name,
                            (double)$r->quantity                            
                        );
                $summaryArray[] = $arr;
            }
         
        $rowEndIdx = $rowIdx+2+($summary->count()-1);
        $this->daily_sales_product_summary_total_idx = ($rowEndIdx+1);
        $summaryArray[] = ['','','','','GRAND TOTAL',
                '=SUM(F'.($rowIdx+2).':F'.$rowEndIdx.')'
            ];

        return $summaryArray;
    }

    function export_daily_sales_cash_flow($start, $end, $branch_id)
    {
        $sales = DB::table('orders')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->join('stocks', 'stocks.id', '=', 'order_items.stock_id')
        ->join('products', 'products.id', '=', 'stocks.product_id')
        ->select(DB::raw("SUM(order_items.quantity * (order_items.unit_price - order_items.discount)) as total"))
        ->where('order_date', '>=', $start)
        ->where('order_date', '<=', $end)
        ->where('orders.branch_id', '=', $branch_id)
        ->where('orders.payment_status_id', '!=', (int)PaymentStatus::Receivables)
        ->where('orders.order_status_id', '=', (int)OrderStatus::Completed)
        ->get();
        $receivables = DB::table('orders')
        ->join('order_items', 'orders.id', '=', 'order_items.order_id')
        ->join('stocks', 'stocks.id', '=', 'order_items.stock_id')
        ->join('products', 'products.id', '=', 'stocks.product_id')
        ->select(DB::raw("SUM(order_items.quantity * (order_items.unit_price - order_items.discount)) as total"))
        ->where('order_date', '>=', $start)
        ->where('order_date', '<=', $end)
        ->where('orders.branch_id', '=', $branch_id)
        ->where('orders.payment_status_id', '=',  (int)PaymentStatus::Receivables)
        ->where('orders.order_status_id', '=', (int)OrderStatus::Completed)
        ->get();
        $expenses = DB::table('expenses')
        ->select(DB::raw("SUM(expenses.amount) as total"))
        ->where('expense_date', '>=', $start)
        ->where('expense_date', '<=', $end)
        ->where('branch_id', '=', $branch_id)
        ->get();

        $sales_amount = $sales->count() > 0 ? (double)$sales[0]->total : 0; 
        $receivable_amount = $receivables->count() > 0 ? (double)$receivables[0]->total : 0; 
        $expenses_amount = $expenses->count() > 0 ? (double)$expenses[0]->total : 0; 
        

        $summaryArray[] = ['CASH FLOW']; 
        $summaryArray[] = []; 
        $summaryArray[] = ['Sales',$sales_amount]; 
        $summaryArray[] = ['Collectibles',$receivable_amount]; 
        $summaryArray[] = ['TOTAL SALES',$sales_amount-$receivable_amount]; 
        $summaryArray[] = ['LESS: Expense/Petty Cash', $expenses_amount]; 
        $summaryArray[] = ['NET SALES',$sales_amount-$receivable_amount-$expenses_amount]; 
        $summaryArray[] = ['Disbursement','']; 
        $summaryArray[] = ['Loan','']; 
        $summaryArray[] = ['CASH ON HAND','']; 

        return $summaryArray;
    }


    public function expensesExcelReport($start, $end, $branch_id)
    {
        $report = $this->get_expenses_data($start, $end, $branch_id);
        

        $branch = Branch::find($branch_id);
        $report_date = Carbon::parse($start)->format('Y-m-d');
        $title = "Daily Expenses Report ".$report_date." - ".$branch->name;        
        $expensesArray[] = ['Windglass Marketing Inc'];
        $expensesArray[] = [$branch->name];
        $expensesArray[] = ['Expenses'];
        $expensesArray[] = [$report_date];
        $expensesArray[] = [];
        $expensesArray[] = ['DATE', '#', 'PAYEE', 'PARTICULARS', 'AMOUNT'];


        $idx = 1;
        foreach ($report as $r) {
           
            $arr = array(
                        Carbon::parse($r->expense_date)->format('Y-m-d'),
                        $r->id,
                        $r->payee,
                        $r->particulars,
                        (double)$r->amount,
                    );
            $expensesArray[] = $arr;
            $idx++;
        }

        $rowStart = 7;
        $rowEnd = $rowStart+$report->count()-1;

        $expensesArray[] = ['','','','SUB TOTAL',
            '=SUM(E'.$rowStart.':E'.$rowEnd.')',
        ];

        // Generate and return the spreadsheet
        Excel::create('expenses', function($excel) use ($expensesArray, $title, $rowStart, $rowEnd) {
            $excel->setTitle($title);
            $excel->setCreator('Laravel')->setCompany('Windglass Company');
            $excel->setDescription($title);

            // Build the spreadsheet, passing in the payments array
            $excel->sheet('sheet1', function($sheet) use ($expensesArray, $rowStart, $rowEnd) {
                $sheet->fromArray($expensesArray, null, 'A1', false, false);
               $this->updateExpensesExcelStyles($sheet, $rowStart, $rowEnd);
                
            });

        })->download('xlsx');
    }

      
    function get_expenses_data($start, $end, $branch_id)
    {

        $expenses =  DB::table('expenses')
        ->where('expense_date', '>=', $start)
        ->where('expense_date', '<', $end)
        ->where('branch_id', '=', $branch_id)
        ->get();

        return $expenses;
    }

    private function updateExpensesExcelStyles($sheet, $rowStartIdx, $rowEndIdx) {
        
        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A2:D2');
        $sheet->mergeCells('A3:D3');
        $sheet->mergeCells('A4:D4');
        
        //format

        $sheet->setColumnFormat(array('E'.$rowStartIdx.':E'.($rowEndIdx+1).'' => '0.00'));

        

        //borders
            $sheet->getStyle('A'.($rowEndIdx+1).':E'.($rowEndIdx+1))->applyFromArray(array(
                'borders' => array(
                    'top' => [
                        'style' => PHPExcel_Style_Border::BORDER_THIN,
                        'color' => ['argb' => '000000'],
                    ],
                )
            ));
       
        
    }
}