<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stock;
use App\Models\Enums\StockStatus;
use Datatables;
use Validator;

class StockController extends Controller
{
    public function index(){ 
        return view("home.views.stocks");
    }

    public function list() {
        $stocks = Stock::with('product', 'branch')->select('stocks.*');;
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
}

