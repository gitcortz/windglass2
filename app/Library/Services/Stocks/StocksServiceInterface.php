<?php
// app/Library/Services/Contracts/CustomServiceInterface.php
namespace App\Library\Services\Stocks;
  
Interface StocksServiceInterface
{
    public function completedOrder($orderId);
    public function moveStocks($stock_id, $from_id, $to_id, $qty_current, $qty_change, $type);
}
