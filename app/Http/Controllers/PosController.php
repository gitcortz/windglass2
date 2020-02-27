<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Enums\OrderStatus;
use App\Models\Enums\PaymentStatus;
use Datatables;

class PosController extends Controller
{
    public function index(){ 
        return view("home.views.pos");
    }

    public function session(){ 
        
        //$sales = Order::with('customer')->select('orders.*, customers.name as customer');
        $sales = Order::join('customers', 'orders.customer_id', '=', 'customers.id')
            ->select(['orders.*', 'customers.name as customername']);

        //return Datatables::of($sales)
        return Datatables::of($sales)
                /*->addColumn('customername', function (Order $order) {
                    return $order->customer ? $order->customer->name : '';
                })*/
                
                /*->addColumn('customer2', function (Order $order) {
                    return $order->customer ? $order->customer : '';
                })*/
                ->addColumn('rider', function (Order $order) {
                    return 'rider';
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

    private function session_action_button($orders) {
        if ($orders->order_status_id == OrderStatus::Processing) {
            return '<a href="#" class="btn btn-danger" action="deliver" data-id="'.$orders->id.'">Deliver</a>';
        } else if ($orders->order_status_id == OrderStatus::Delivering) {
            return '<a href="#" class="btn btn-danger" action="complete" data-id="'.$orders->id.'">Complete</a>';
        } else {
            return '';
        }
        
    }
}
