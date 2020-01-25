<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransferItem extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['stock_transfer_id', 'stock_id', 'quantity', 'actual'];

    public function stock_transfer(){
        return $this->belongsTo('App\Models\StockTransfer');
    }

    public function stock(){
        return $this->belongsTo('App\Models\Stock');
    }
}
