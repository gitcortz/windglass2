<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'stock_id', 'quantity', 'unit_price', 'discount'];

    public function stock(){
        return $this->belongsTo('App\Models\Stock');
    }
}
