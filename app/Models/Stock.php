<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;
    
    public function product(){
        return $this->belongsTo('App\Models\Product');
    }
    public function branch(){
        return $this->belongsTo('App\Models\Branch');
    }
}
