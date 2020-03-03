<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    protected $fillable = ['stock_id', 'from_id', 'to_id', 'movement_type', 'quantity', 'quantity_before'];
}
