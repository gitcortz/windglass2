<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderBringIn extends Model
{
    protected $fillable = ['order_id', 'stock_id', 'quantity'];

    public function stock(){
        return $this->belongsTo('App\Models\Stock');
    }
}
