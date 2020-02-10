<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;
    protected $fillable = ['first_name', 'last_name', 'email', 'address', 'city_id', 'phone', 'mobile', 'notes', 'hire_date',
                         'base_salary', 'biometrics_id', 'employeetype_id'];
                        
    public function employeetype(){
        return $this->belongsTo('App\Models\EmployeeType');
    }

    public function city(){
        return $this->belongsTo('App\Models\City');
    }
}
