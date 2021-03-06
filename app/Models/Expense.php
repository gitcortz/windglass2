<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $fillable = ['payee', 'particulars', 'expense_date', 'amount', 'branch_id'];
    
    public function branch(){
        return $this->belongsTo('App\Models\Branch');
    }
}
