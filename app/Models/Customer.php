<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'email', 'address', 'city_id', 'phone', 'mobile', 'notes'];
    
    public function city(){
        return $this->belongsTo('App\Models\City');
    }
}
