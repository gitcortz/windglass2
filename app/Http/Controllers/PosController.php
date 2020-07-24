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

    public function receipt($id){ 
        $order = Order::with('order_items')->find($id);
        return view("home.views.receipt", ['order' => $order]);
    }

    public function list(Request $request) {
    
        $branch_id = $request->id;
    
        $matchThese = [];
        $matchThese['branch_id'] =  $branch_id;
        if($request->customer_id)
            $matchThese['customer_id'] = $request->customer_id;
        if($request->order_id)
            $matchThese['orders.id'] = $request->order_id;

        //$stocks = Stock::where($matchThese)->with('product', 'branch')->select('stocks.*');;
        $sales = Order::where($matchThese)->with('order_items')->with('order_items.stock')->with('order_items.stock.product')
        ->with('order_bringins')->with('order_bringins.stock')->with('order_bringins.stock.product')
        ->join('customers', 'orders.customer_id', '=', 'customers.id')
        ->leftJoin('employees', 'orders.rider_id', '=', 'employees.id')
        ->select(['orders.*', 'customers.name as customername', 'employees.first_name as rider_firstname', 
                'employees.last_name as rider_lastname']);

        //return Datatables::of($sales)
        return Datatables::of($sales)
            ->addColumn('rider', function (Order $order) {
                return $order->rider_firstname." ".$order->rider_lastname;
            })
            ->addColumn('order_status', function (Order $order) {
                return $order->order_status_id == "0" ? "Cancelled" : OrderStatus::getName($order->order_status_id);
            })
            ->addColumn('payment_status', function (Order $order) {
                return PaymentStatus::getName($order->payment_status_id);
            })
            ->addColumn('total', function (Order $order) {
                return $order->sub_total - $order->discount;  
            })
            ->addColumn("action_btns", function($order) {
                return '<a href="#" class="btn btn-info btn-sm" action="view" data-id="'.$order->id.'">View</a>';
            })            
            ->rawColumns(["action_btns"])
            ->make(true);
    

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
                .'<option value="'.OrderStatus::Void.'" '.($orders->order_status_id == OrderStatus::Void ? "selected" : "").' >Cancelled</option>'
                .'<option value="'.OrderStatus::Ordered.'" '.($orders->order_status_id == OrderStatus::Ordered ? "selected" : "").' >Ordered</option>'
                .'<option value="'.OrderStatus::Delivered.'" '.($orders->order_status_id == OrderStatus::Delivered ? "selected" : "").' >Delivered</option>'
                .'<option value="'.OrderStatus::Completed.'" '.($orders->order_status_id == OrderStatus::Completed ? "selected" : "").' >Completed</option>'
                .'</select>';
        }
    }

}
