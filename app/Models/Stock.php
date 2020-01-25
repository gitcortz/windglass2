<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;
    protected $fillable = ['branch_id', 'product_id', 'initial_stock', 'current_stock', 'stock_status_id'];
    
    public function product(){
        return $this->belongsTo('App\Models\Product');
    }
    public function branch(){
        return $this->belongsTo('App\Models\Branch');
    }
}
