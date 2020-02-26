<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserBranches extends Model
{
    public function branch(){
        return $this->belongsTo('App\Models\Branch');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
