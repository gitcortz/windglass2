<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    
    protected $fillable = ['customer_id', 'branch_id', 'order_date', 'delivered_date', 'address', 'city', 'order_status_id'
            , 'payment_status_id', 'payment_method_id', 'discount', 'sub_total', 'rider_id'];

    public function order_items(){
        return $this->hasMany('App\Models\OrderItems');
    }

    public function branch(){
        return $this->belongsTo('App\Models\Branches');
    }

    public function customer(){
        return $this->belongsTo('App\Models\Customer');
    }

    public function rider(){
        return $this->belongsTo('App\Models\User');
    }

    public function order_status() {
        return OrderStatus::getName($this->order_status_id);
    }
}
