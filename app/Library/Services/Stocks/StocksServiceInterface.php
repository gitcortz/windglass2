<?php
// app/Library/Services/Contracts/CustomServiceInterface.php
namespace App\Library\Services\Stocks;
  
Interface StocksServiceInterface
{
    public function completedOrder($orderId);
    public function cancelledOrder($orderId);
    public function moveStocks($stock_id, $from_id, $to_id, $qty_current, $qty_change, $type);
    public function getBranchStock($branch_id, $product_id);
}
