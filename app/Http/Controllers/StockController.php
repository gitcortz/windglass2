<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\Enums\StockStatus;
use App\Models\Enums\MovementType;
use App\Library\Services\Stocks\StocksServiceInterface;
use Illuminate\Support\Facades\DB;
use Datatables;
use Validator;

class StockController extends Controller
{
    public function index(){ 
        return view("home.views.stocks");
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

    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), array(
            'branch_id' => 'required',
            'product_id' => 'required',     
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = Stock::create($request->all());

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = Stock::find($id);

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), array(
            'branch_id' => 'required',
            'product_id' => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = Stock::find($id);
        $data->branch_id =  $request->input('branch_id');
        $data->product_id = $request->input('product_id');
        $data->initial_stock = $request->input('initial_stock');
        $data->current_stock = $request->input('current_stock');
        $data->stock_status_id = $request->input('stock_status_id');

        $data->save();

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function destroy($id)
    {
        $task = Stock::destroy($id);

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }

    public function movements(Request $request)
    {
        $stock_id = $request->id;
        
        $stock_mv = DB::table('stock_movements')
            ->leftJoin('branches as from_branch', 'from_branch.id', '=', 'stock_movements.from_id')
            ->leftJoin('branches as to_branch', 'to_branch.id', '=', 'stock_movements.to_id')
            ->where('stock_id', $stock_id)
            ->select('stock_movements.*','from_branch.name as from','to_branch.name as to')
            ->orderBy('created_at', 'desc');

        //$stock_mv = StockMovement::with('branch')->where('stock_id', $stock_id)->select('stock_movements.*');
        return Datatables::of($stock_mv)
                ->addColumn('movement_type_name', function ($row) {
                    return MovementType::getName($row->movement_type);
                })
                ->make(true);
    }

    public function add_movement(Request $request, StocksServiceInterface $stocksServiceInstance)
    {
        $validator = Validator::make($request->input(), array(
            'from_id' => 'required',
            'stock_id' => 'required',     
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $stocksServiceInstance->moveStocks(
                        $request->input('stock_id'),
                        $request->input('from_id'),
                        0,
                        null,
                        $request->input('quantity'),
                        $request->input('movement_type')
                    );
        
        //$data = StockMovement::create($request->all());
        //print_r($request->all());
        
        
        return response()->json([
            'error' => false,
            'data'  => "OK",
        ], 200);
    }

}

