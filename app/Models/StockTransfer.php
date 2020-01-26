<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransfer extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['from_branch_id', 'to_branch_id', 'scheduled_date', 'received_date', 'transfer_status_id', 'remarks'];

    public function from_branch(){
        return $this->belongsTo('App\Models\Branch');
    }
    public function to_branch(){
        return $this->belongsTo('App\Models\Branch');
    }
    public function stock_transfer_items(){
        return $this->hasMany('App\Models\StockTransferItem');
    }
}
