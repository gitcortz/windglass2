<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeLoanTransaction extends Model
{
    protected $fillable = ['employee_id', 'employee_loan_id', 'before_amount', 'after_amount', 'loan_transaction_type'];

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }

    public function employee_loan(){
        return $this->belongsTo('App\Models\EmployeeLoan');
    }


}
