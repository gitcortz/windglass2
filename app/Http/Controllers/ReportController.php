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
}
