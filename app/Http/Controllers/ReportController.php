<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Payroll;
use App\Models\Order;
use App\Models\Enums\OrderStatus;
use App\Library\Services\Payroll\PayrollServiceInterface;
use App\Models\Enums\PaymentStatus;
use Illuminate\Support\Facades\DB;
use \Carbon\Carbon;
use Datatables;
use Validator;

class ReportController extends Controller
{
    public function index(){ 
        return view("home.views.reports.reports");
    }

    public function dailysalesindex(){ 
        return view("home.views.reports.dailysales");
    }

    public function loansindex(){ 
        return view("home.views.reports.loans");
    }

    public function pendingorderindex(){ 
        return view("home.views.reports.pendingorder");
    }

    public function loansreport(Request $request) {
        $validator = Validator::make($request->input(), array(
            'weekno' => 'required',
            'year' => 'required',
        ));
        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }
        
        $sales = Payroll::where('year', $request->query('year'))
                ->where('week_no', $request->query('weekno'))
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
       
        return Datatables::of($sales)
            ->make(true);
        
    }

    public function loansreportexport(Request $request, PayrollServiceInterface $payrollServiceInstance)
    {
        $validator = Validator::make($request->input(), array(
            'weekno' => 'required',
            'year' => 'required',
        ));
        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }


        $payrollServiceInstance->exportLoanReport($request->query('year'), $request->query('weekno'));       
    }

    public function dailysalesreport(Request $request) {
        $start = new Carbon(date('Y-m-d', strtotime($request->query('date'))));
        $end = $start->copy()->addDays(1);
        
        $report = $this->get_sales_data($start, $end);
       
        return Datatables::of($report)
                ->addColumn('total', function ($report) {
                    return $report->quantity * ($report->unit_price - $report->discount);
                })
                ->addColumn('rider', function ($report) {
                    return "rider";
                })
                ->addColumn('payment_status', function ($report) {
                    return PaymentStatus::getName($report->payment_status_id);
                })
                ->make(true);

    }

    function dailysalesreportpdf(Request $request)
    {
        $start = new Carbon(date('Y-m-d', strtotime($request->query('date'))));
        $end = $start->copy()->addDays(1);
        $report = $this->get_sales_data($start, $end);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_sales_data_to_html($report));
        return $pdf->stream();
    }

    public function pendingorderreport(Request $request) {
        $branch_id = $request->id;
        
        $sales = Order::with('order_items')->with('order_items.stock')->with('order_items.stock.product')
            ->with('order_bringins')->with('order_bringins.stock')->with('order_bringins.stock.product')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->leftJoin('employees', 'orders.rider_id', '=', 'employees.id')
            ->select(['orders.*', 'customers.name as customername', 'employees.first_name as rider_firstname', 
                    'employees.last_name as rider_lastname'])
            ->where("branch_id",  $branch_id)
            ->whereNotIn("order_status_id", [OrderStatus::Completed, OrderStatus::Void]);

        return Datatables::of($sales)
                ->addColumn('rider', function (Order $order) {
                    return $order->rider_firstname." ".$order->rider_lastname;
                })
                ->addColumn('order_status', function (Order $order) {
                    return OrderStatus::getName($order->order_status_id);
                })
                ->addColumn('payment_status', function (Order $order) {
                    return PaymentStatus::getName($order->payment_status_id);
                })
                ->addColumn("action_btns", function($orders) {
                    return $this->session_action_button($orders); 
                })
                
                ->rawColumns(["action_btns"])
                ->make(true);
    }

    function get_sales_data($start, $end)
    {

        $report = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('stocks', 'stocks.id', '=', 'order_items.stock_id')
            ->join('products', 'products.id', '=', 'stocks.product_id')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->select('order_date', 'orders.id', 'customers.name as customer_name', 'products.name as product_name', 
                    'order_items.quantity', 'order_items.unit_price', 
                    'order_items.discount', 'orders.payment_status_id')
            ->where('order_date', '>=', $start)
            ->where('order_date', '<=', $end)
            ->get();
        return $report;
    }


    function convert_sales_data_to_html($report)
    {      
        $output = '
        <h3 align="center">Windglass Marketing</h3>
        <h4 align="center">DAILY SALES REPORT</h4>
        <table width="100%" style="font-size:10px;" border="0" cellspacing="0" cellpadding="2" >
        <tr>
        <th>DATE</th>
        <th>INV #</th>
        <th>CUSTOMER NAME</th>
        <th>PRODUCT</th>
        <th>QTY</th>
        <th>PRICE</th>
        <th>DISC.</th>
        <th>AMT.</th>
        <th>RIDER</th>
        <th>STATUS</th>
        </tr>
        ';
        
     
        foreach($report as $r)
        {
            $output .= '
            <tr>
            <td>'.Carbon::parse($r->order_date)->format('Y-m-d').'</td>
            <td align="center">'.$r->id.'</td>
            <td >'.$r->customer_name.'</td>
            <td>'.$r->product_name.'</td>
            <td align="center">'.$r->quantity.'</td>
            <td align="right">'.$r->unit_price.'</td>
            <td align="right">'.$r->discount.'</td>
            <td align="right">'. number_format($r->quantity * ($r->unit_price - $r->discount), 2, '.', ',').'</td>
            <td align="center">rider</td>
            <td align="center">'.PaymentStatus::getName($r->payment_status_id).'</td>
            </tr>
            ';
        }
        $output .= '</table>';
        return $output;
    }

    private function session_action_button($orders) {
        
        if ($orders->order_status_id == OrderStatus::Completed) {
            return '<div>Complete</div>';
        }
        else {
            $update_action_button = '';
            if ($orders->order_status_id == OrderStatus::Delivered){
                $update_action_button = $this->update_action_button($orders->id);
            }

            return '<select class="order_action"  data-id="'.$orders->id.'" onfocus="this.setAttribute(\'prev\',this.value);">'                
                .($orders->order_status_id != OrderStatus::Draft ? '' : 
                    ('<option value="'.OrderStatus::Draft.'" '.($orders->order_status_id == OrderStatus::Draft ? "selected" : "").' >Draft</option>'))
                .($this->isNotDraftOrdered($orders->order_status_id) ? '' : 
                    ('<option value="'.OrderStatus::Ordered.'" '.($orders->order_status_id == OrderStatus::Ordered ? "selected" : "").' >Ordered</option>'))                    
                .($this->isNotDraftOrderedDelivered($orders->order_status_id) ? '' : 
                    ('<option value="'.OrderStatus::Delivered.'" '.($orders->order_status_id == OrderStatus::Delivered ? "selected" : "").' >Delivered</option>'))
                .'<option value="'.OrderStatus::Completed.'" '.($orders->order_status_id == OrderStatus::Completed ? "selected" : "").' >Completed</option>'
                .(!session("isAdmin") ? "" :
                    '<option value="'.OrderStatus::Void.'" '.($orders->order_status_id == OrderStatus::Void ? "selected" : "").' >Cancelled</option>')
                .'</select>'.$update_action_button;
        }
    }

    private function update_action_button($orders_id) {
        $order = "pending.update_modal(".$orders_id.")";
        return "<a href='javascript:void(0)' onclick='".$order."' class='btn btn-info btn-xs remove-empty'>...</a>";
    }

    private function isNotDraftOrdered($status_id) {
        return $status_id != OrderStatus::Ordered && $status_id != OrderStatus::Draft;
    }
    private function isNotDraftOrderedDelivered($status_id) {
        return $status_id != OrderStatus::Ordered && $status_id != OrderStatus::Draft &&  $status_id != OrderStatus::Delivered ;
    }

}
