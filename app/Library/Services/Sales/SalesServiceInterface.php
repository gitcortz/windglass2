<?php
// app/Library/Services/Contracts/CustomServiceInterface.php
namespace App\Library\Services\Sales;
  
Interface SalesServiceInterface
{
    public function exportDailySales($start, $end, $branch_id);
}
