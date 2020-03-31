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

    public function index_v2(){ 
        return view("home.views.pos-v2");
    }

    public function session(){ 
        
        //$sales = Order::with('customer')->select('orders.*, customers.name as customer');
        $sales = Order::with('order_items')->with('order_items.stock')->with('order_items.stock.product')
            ->with('order_bringins')->with('order_bringins.stock')->with('order_bringins.stock.product')
            ->join('customers', 'orders.customer_id', '=', 'customers.id')
            ->leftJoin('employees', 'orders.rider_id', '=', 'employees.id')
            ->select(['orders.*', 'customers.name as customername', 'employees.first_name as rider_firstname', 
                    'employees.last_name as rider_lastname']);

        //return Datatables::of($sales)
        return Datatables::of($sales)
                /*->addColumn('customername', function (Order $order) {
                    return $order->customer ? $order->customer->name : '';
                })*/
                
                /*->addColumn('customer2', function (Order $order) {
                    return $order->customer ? $order->customer : '';
                })*/
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

    private function session_action_button($orders) {
        
        if ($orders->order_status_id == OrderStatus::Completed) {
            return '<div>Complete</div>';
        }
        else {
        return '<select class="order_action"  data-id="'.$orders->id.'">'
                .'<option value="'.OrderStatus::Void.'" '.($orders->order_status_id == OrderStatus::Void ? "selected" : "").' >Void</option>'
                .'<option value="'.OrderStatus::Processing.'" '.($orders->order_status_id == OrderStatus::Processing ? "selected" : "").' >Processing</option>'
                .'<option value="'.OrderStatus::Delivering.'" '.($orders->order_status_id == OrderStatus::Delivering ? "selected" : "").' >Delivering</option>'
                .'<option value="'.OrderStatus::Completed.'" '.($orders->order_status_id == OrderStatus::Completed ? "selected" : "").' >Completed</option>'
                .'</select>';
        }
    }

}
