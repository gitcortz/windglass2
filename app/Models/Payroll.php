<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    protected $fillable = ['employee_id', 'year', 'week_no', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday',
                        'saturday', 'sunday', 'total_days', 'total_hours', 'total_loans', 'vale_payment', 'day_rate', 'total',
                        'loan_payment', 'total_ot_hours', 'total_ot_amount', 'grand_total', 'payroll_status'];

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }
    
}