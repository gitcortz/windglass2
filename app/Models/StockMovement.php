<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = ['stock_id', 'from_id', 'to_id', 'movement_type', 'quantity', 'quantity_before'];

    public function from(){
        return $this->belongsTo('App\Models\Branch');
    }

    public function to(){
        return $this->belongsTo('App\Models\Branch');
    }

    public function movement_type() {
        return MovementType::getName($this->movement_type);
    }

}
