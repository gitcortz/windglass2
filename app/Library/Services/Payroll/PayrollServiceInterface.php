<?php
// app/Library/Services/Contracts/CustomServiceInterface.php
namespace App\Library\Services\Payroll;
  
Interface PayrollServiceInterface
{
    public function generatePayroll($year, $weekno);
    public function processCsvData($data);
    public function exportPayroll($year, $weekno);
    public function approvePayroll($year, $weekno);
}
