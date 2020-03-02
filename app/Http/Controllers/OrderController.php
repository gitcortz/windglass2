<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use Datatables;
use Validator;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(){ 
        return view("home.views.orders");
    }

    public function list() {
      
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), array(
            'branch_id' => 'required',
            'customer_id' => 'required',     
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }
          
        $data = Order::create([
            'branch_id' => $request->branch_id, 
            'customer_id' => $request->customer_id,
            'order_date' => Carbon::now('UTC'),
            'delivered_date'=>$request->delivered_date,
            'address'=>$request->address,
            'city'=>$request->city,
            'order_status_id'=>$request->order_status_id,
            'payment_status_id'=>$request->payment_status_id,
            'payment_method_id'=>$request->payment_method_id,
            'discount'=>$request->discount,
            'sub_total'=>$request->sub_total,
            
          ]);
          
        $data_id = $data->id;
        foreach ($request->items as $item) {
            $transfer_item = OrderItem::create([
                'order_id' => $data->id,     
                'stock_id' => $item['stock_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['unit_price'],
            ]);  
        }
        
        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = Order::find($id);

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $data1 = json_decode($request->getContent());
        
        $data = Order::find($id);
        if ($data1->order_status_id) {
            $data->order_status_id =  $data1->order_status_id;
            $data->save();
        }

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function destroy($id)
    {
      
    }

}