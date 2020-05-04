<?php
// app/Library/Services/Contracts/CustomServiceInterface.php
namespace App\Library\Services\Sales;
  
Interface SalesServiceInterface
{
    public function salesExcelReport($start, $end, $branch_id);
    public function expensesExcelReport($start, $end, $branch_id);
}
