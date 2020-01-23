<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'description', 'producttype_id', 'brand_id', 'unit_price'];
    
    public function producttype(){
        return $this->belongsTo('App\Models\ProductType');
    }
    public function brand(){
        return $this->belongsTo('App\Models\Brand');
    }
}
