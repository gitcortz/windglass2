<?php

namespace App\Library\Services\Stocks;
use Carbon\Carbon;
use App\Models\OrderItem;
use App\Models\Stock;
use App\Models\Enums\MovementType;
use Excel;
use DateTime;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class StocksService implements StocksServiceInterface
{
    
    public function completedOrder($orderId)
    {       
        $orderItems = OrderItem::with('stock')
        ->where('order_id', $orderId)
        ->get();

        foreach ($orderItems as $item) {
            $this->moveStocks($item->stock_id, $item->stock->branch_id, 0, 
            $item->stock->current_stock ,$item->quantity, MovementType::Sold);
        }

    }

    public function moveStocks($stock_id, $from_id, $to_id, $qty_current, $qty_change, $type) {
            
            if ($type == MovementType::Sold || $type == MovementType::Transfer
                    || $type == MovementType::Lost || $type == MovementType::Destroyed) {
                $qty_change = $qty_change * -1;
            }

            $stock = Stock::find($stock_id);
             
            if ($qty_current == null) {
                $qty_current = $stock->current_stock;
            }

            $computed_stock = $qty_current + $qty_change;
            
            \App\Models\StockMovement::create([
                'stock_id' => $stock_id, 
                'from_id' => $from_id,
                'to_id' => $to_id,
                'movement_type' => $type,
                'quantity' => $computed_stock,
                'quantity_before' => $qty_current,
            ]);

            
            $stock->current_stock = $computed_stock;
            $stock->save();
                
    }

    public function getBranchStock($branch_id, $product_id) {
        $stock = Stock::where('branch_id', $branch_id)
                ->where('product_id', $product_id)
                ->get();

        if ($stock->count() > 0){
            return $stock[0];
        } else {
           //stock not found, create stock
           $data = Stock::create([
            'branch_id' => $branch_id, 
            'product_id' => $product_id,
            'initial_stock' => 0,
            'current_stock' => 0,
            'stock_status_id' => 1,
            ]);

            return $data;
        }

    }
    
}