<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockTransferItem;
use App\Models\Enums\TransferStatus;
use Datatables;
use Validator;

class StockTransferItemController extends Controller
{
    public function index(){ 
        return view("home.views.stocktransferitems");
    }

    public function list() {
        $stocktransferitems = StockTransferItem::with('stock')->select('stock_transfer_items.*');;
        return Datatables::of($stocktransferitems)
                ->addColumn('product', function (StockTransferItem $item) {
                    return $item->stock ? $item->stock->product->name : '';
                })
                ->addColumn("action_btns", function($stocktransferitems) {
                    return '<a href="#" class="btn btn-info" action="remove" data-id="'.$stocktransferitems->id.'">X</a>';
                })
                ->rawColumns(["action_btns"])
                ->make(true);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), array(
            'stock_transfer_id' => 'required',
            'stock_id' => 'required',
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = StockTransferItem::create($request->all());

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = StockTransferItem::find($id);

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), array(
            'stock_transfer_id' => 'required',
            'stock_id' => 'required',    
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

        $data = StockTransferItem::find($id);
        $data->stock_id =  $request->input('stock_transfer_id');
        $data->stock_id =  $request->input('stock_id');
        $data->quantity = $request->input('quantity');
        $data->actual = $request->input('actual');
        $data->save();

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function destroy($id)
    {
        $task = StockTransferItem::destroy($id);

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }
}

