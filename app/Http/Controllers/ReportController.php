<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
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

    public function dailysalesreport(Request $request) {
        $start = new Carbon(date('Y-m-d', strtotime($request->query('date'))));
        $end = $start->copy()->addDays(1);
        
        $report = $this->get_customer_data($start, $end);
       
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
        $report = $this->get_customer_data($start, $end);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($this->convert_customer_data_to_html($report));
        return $pdf->stream();
    }

    function get_customer_data($start, $end)
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


    function convert_customer_data_to_html($report)
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

}
