<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderBringIn;
use App\Models\Enums\OrderStatus;
use App\Library\Services\Stocks\StocksServiceInterface;
use Datatables;
use Validator;
use Carbon\Carbon;

class OrderController extends Controller
{
    public function index(){ 
        return view("home.views.orders");
    }

    public function list(Request $request) {
        
        $matchThese = [];
        if($request->branch_id)
            $matchThese['branch_id'] = $request->branch_id;

        $stocks = Stock::where($matchThese)->with('product', 'branch')->select('stocks.*');;

        
        return Datatables::of($stocks)
                ->addColumn('product', function (Stock $stock) {
                    return $stock->product ? $stock->product->name : '';
                })
                ->addColumn('producttype', function (Stock $stock) {
                    return $stock->product ? $stock->product->producttype->name : '';
                })
                ->addColumn('branch', function (Stock $stock) {
                    return $stock->branch ? $stock->branch->name : '';
                })
                ->addColumn('status', function (Stock $stock) {
                    return StockStatus::getName($stock->stock_status_id);
                })
                ->addColumn("action_btns", function($stocks) {
                    return '<a href="#" class="btn btn-info" action="edit" data-id="'.$stocks->id.'">Edit</a>'
                    .'&nbsp;<a href="#" class="btn btn-danger" action="delete" data-id="'.$stocks->id.'">Delete</a>';
                })
                ->rawColumns(["action_btns"])
                ->make(true);

    }

    public function store(Request $request, StocksServiceInterface $stocksServiceInstance)
    {
        $validator = Validator::make($request->input(), array(
            'customer_id' => 'required',     
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        if ($request->id == 0) {
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
                    'createdby_id'=>session("user_details")->id
                ]);
                
                $data_id = $data->id;
                foreach ($request->items as $item) {
                    $order_item = OrderItem::create([
                        'order_id' => $data->id,     
                        'stock_id' => $item['stock_id'],
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['unit_price'],
                        'discount' => $item['discount'],
                    ]);  
                }
        }
        else {
            $data = Order::find($request->id);            
            $data->rider_id = $request->input('rider_id');
            $data->order_status_id =  $request->input('order_status_id');
            $data->lastupdatedby_id = session("user_details")->id;

            if ($data->order_status_id  == OrderStatus::Draft) {              
                $data->sub_total =  $request->input('sub_total');
                $data->discount =  $request->input('discount');
            
                $request_stockIds = array_column($request->items, 'stock_id');
                $orderitems = OrderItem::where("order_id", $data->id)->get();
                $orderitem_stockIds = OrderItem::where("order_id", $data->id)->pluck('stock_id')->toArray();
                $orderitem_stockIds = array_map('strval',$orderitem_stockIds);                        
                $delete=array_diff($orderitem_stockIds,$request_stockIds);
                $add=array_diff($request_stockIds,$orderitem_stockIds);
                $update=array_intersect($orderitem_stockIds,$request_stockIds);
            
                //add|update
                foreach ($request->items as $item) {
                    if (in_array($item["stock_id"], $add)){
                        $order_item = OrderItem::create([
                            'order_id' => $data->id,     
                            'stock_id' => $item['stock_id'],
                            'quantity' => $item['quantity'],
                            'unit_price' => $item['unit_price'],
                            'discount' => $item['discount'],
                        ]);                       
                    }
                    else if (in_array($item["stock_id"], $update)){
                        $updateitems =  $orderitems->where("stock_id", $item["stock_id"]);
                        foreach($updateitems as $updateitem) {
                            $updatethis = OrderItem::find($updateitem["id"]);
                            $updatethis->quantity = $item['quantity'];
                            $updatethis->unit_price = $item['unit_price'];
                            $updatethis->discount = $item['discount'];
                            $updatethis->save();                           
                        }
                    }          
                }
                
                foreach($orderitems as $orderitem) {                    
                    if (in_array($orderitem->stock_id, $delete)){
                        $task = OrderItem::destroy($orderitem->id);
                    }
                }


            }
            $data->save();           
        }
        
        if ($data->order_status_id  == OrderStatus::Completed) {
            $stocksServiceInstance->completedOrder($data->id);
        }
        if ($data->order_status_id  == OrderStatus::Void) {
            $stocksServiceInstance->cancelledOrder($data->id);
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

    public function update(Request $request, $id, StocksServiceInterface $stocksServiceInstance)
    {
        $data1 = json_decode($request->getContent(), true);
        $data = Order::find($id);
        if ($data1["order_status_id"] ||$data1["rider_id"] ) {

            if ($data1["order_status_id"] != '')
                $data->order_status_id = $data1["order_status_id"];
            
            if ($data1["rider_id"] != '')
                $data->rider_id = $data1['rider_id'];

            $data->save();
        }

        if ($data1["cylinders"]) {
            $affectedRows = OrderBringIn::where('order_id', '=', $id)->delete();
            foreach ($data1["cylinders"] as $item) {
                OrderBringIn::create([
                    'order_id' => $id,
                    'stock_id' => $item["id"],
                    'quantity' => $item["quantity"],
                ]);
            }
        }

         //$stocksServiceInstance->completedOrder($id);

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function destroy($id)
    {
      
    }

    public function search(Request $request) {

        if($request->keyword != "") {
            $customers = DB::table('customers')
                ->leftJoin('cities', 'customers.city_id', '=', 'cities.id')
                -> where('customers.name', 'LIKE', '%'.$request->keyword.'%')
                -> orWhere('address', 'LIKE', '%'.$request->keyword.'%')
                -> orWhere('cities.name', 'LIKE', '%'.$request->keyword.'%')
                ->select('customers.*', 'cities.name as city');
        }
        else { 
            $customers = DB::table('customers')
                ->leftJoin('cities', 'customers.city_id', '=', 'cities.id')
                ->select('customers.*', 'cities.name as city');
        }


        return Datatables::of($customers)
                ->addColumn('contact', function ($customer) {
                    return ($customer->phone ? $customer->phone.' / ' : '').$customer->mobile;
                })               
                ->addColumn("action_btns", function($customers) {
                    return '<a href="#" class="btn btn-info btn-sm" action="select" data-id="'.$customers->id.'">Select</a>';
                })
                ->rawColumns(["action_btns"])
                ->make(true);             
  
    }

    
}