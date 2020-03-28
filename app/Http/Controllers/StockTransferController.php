<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockTransfer;
use App\Models\StockTransferItem;
use App\Models\Enums\TransferStatus;
use Datatables;
use Validator;

class StockTransferController extends Controller
{
    public function index(){ 
        return view("home.views.stocktransfers");
    }

    public function list() {
        $stocktransfers = StockTransfer::with('from_branch', 'to_branch')->select('stock_transfers.*');;
        return Datatables::of($stocktransfers)
                ->addColumn('from_branch', function (StockTransfer $stocktransfer) {
                    return $stocktransfer->from_branch ? $stocktransfer->from_branch->name : '';
                })
                ->addColumn('to_branch', function (StockTransfer $stocktransfer) {
                    return $stocktransfer->to_branch ? $stocktransfer->to_branch->name : '';
                })
                ->addColumn('status', function (StockTransfer $stocktransfer) {
                    return TransferStatus::getName($stocktransfer->transfer_status_id);
                })
                ->addColumn("action_btns", function($stocktransfers) {
                    return
                    ($stocktransfers->transfer_status_id != TransferStatus::IsDraft ? '' :
                        '<a href="#" class="btn btn-success" action="transfer" data-id="'.$stocktransfers->id.'">Transfer</a>')
                    .($stocktransfers->transfer_status_id != TransferStatus::Transfer ? '' :
                        '<a href="#" class="btn btn-success" action="receive" data-id="'.$stocktransfers->id.'">Received</a>')
                    .($stocktransfers->transfer_status_id != TransferStatus::IsDraft ? '' :
                            '&nbsp;<a href="#" class="btn btn-info" action="edit" data-id="'.$stocktransfers->id.'">Edit</a>')
                    .($stocktransfers->transfer_status_id != TransferStatus::IsDraft ? '' :                                       
                        '&nbsp;<a href="#" class="btn btn-danger" action="delete" data-id="'.$stocktransfers->id.'">Delete</a>');
                })
                ->rawColumns(["action_btns"])
                ->make(true);        
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), array(
            'from_branch_id' => 'required',
            'to_branch_id' => 'required',     
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }
          
        $data = StockTransfer::create([
            'from_branch_id' => $request->from_branch_id, 
            'to_branch_id' => $request->to_branch_id,
            'transfer_status_id' => $request->transfer_status_id,
            'scheduled_date'=>$request->scheduled_date,
            'received_date' => $request->received_date,
            'remarks' => $request->remarks,
          ]);
          
        $data_id = $data->id;
        foreach ($request->items as $item) {
            $transfer_item = StockTransferItem::create([
                'stock_transfer_id' => $data->id,     
                'stock_id' => $item['stock_id'],
                'quantity' => $item['quantity'],
            ]);  
        }
        
        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function show($id)
    {
        $data = StockTransfer::with('stock_transfer_items.stock.product')->find($id);

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->input(), array(
            'from_branch_id' => 'required',
            'to_branch_id' => 'required',    
        ));

        if ($validator->fails()) {
            return response()->json([
                'error'    => true,
                'messages' => $validator->errors(),
            ], 422);
        }

       
        $data = StockTransfer::find($id);
        $data->from_branch_id =  $request->input('from_branch_id');
        $data->to_branch_id = $request->input('to_branch_id');
        $data->scheduled_date = $request->input('scheduled_date');
        $data->received_date = $request->input('received_date');
        $data->transfer_status_id = $request->input('transfer_status_id');
        $data->remarks = $request->input('remarks');
        $data->save();

        $data_id = $data->id;
        foreach ($request->items as $item) {
            $transfer_item = StockTransferItem::create([
                'stock_transfer_id' => $data->id,     
                'stock_id' => $item['stock_id'],
                'quantity' => $item['quantity'],
            ]);  
        }

        return response()->json([
            'error' => false,
            'data'  => $data,
        ], 200);
    }

    public function destroy($id)
    {
        $task = StockTransfer::destroy($id);

        return response()->json([
            'error' => false,
            'task'  => $task,
        ], 200);
    }

    public function items(Request $request)
    {
        $stock_transfer_id = $request->id;
        $stock_transfers = StockTransferItem::where('stock_transfer_id', $stock_transfer_id)->get();
        return ($stock_transfers);
    }
}

