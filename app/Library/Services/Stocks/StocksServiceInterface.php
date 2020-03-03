<?php
// app/Library/Services/Contracts/CustomServiceInterface.php
namespace App\Library\Services\Stocks;
  
Interface StocksServiceInterface
{
    public function completedOrder($orderId);
}
