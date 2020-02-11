<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Enums\LoanStatus;
use App\Models\Enums\LoanType;

class EmployeeLoan extends Model
{
    use SoftDeletes;
    protected $fillable = ['employee_id', 'loan_amount', 'loan_status_id', 'loan_type_id', 'balance'];

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }

    public function loan_status() {
        return LoanStatus::getName($this->loan_status_id);
    }

    public function loan_type() {
        return LoanType::getName($this->loan_type_id);
    }

}
