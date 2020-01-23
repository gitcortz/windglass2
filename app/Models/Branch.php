<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Branch extends Model
{
    use SoftDeletes;
    protected $fillable = ['code', 'name', 'email', 'address', 'city_id', 'phone', 'mobile'];
    
    public function city(){
        return $this->belongsTo('App\Models\City');
    }
}
