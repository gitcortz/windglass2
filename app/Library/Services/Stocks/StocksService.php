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
        if ($to_id == 0) {
            if ($qty_current == null) {
                $stock = Stock::find($stock_id);
                $qty_current = $stock->current_stock;
            }
            if ($type == MovementType::Sold || $type == MovementType::Transfer
                    || $type == MovementType::Lost || $type == MovementType::Destroyed) {
                $qty_change = $qty_change * -1;
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

            $stock = Stock::find($stock_id);
            $stock->current_stock = $computed_stock;
            $stock->save();
        
        }
    }
    
}