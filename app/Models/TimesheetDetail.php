<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Datetime;

class TimesheetDetail extends Model
{
    protected $fillable = ['id', 'employee_id', 'time_in', 'time_out'];

    public function employee(){
        return $this->belongsTo('App\Models\Employee');
    }

    public function total_hours() {
        $time_in = new DateTime($this->time_in);
        $time_out = new DateTime($this->time_out);
        $diff = $time_out->diff($time_in);
        $hours = round($diff->s / 3600 + $diff->i / 60 + $diff->h + $diff->days * 24, 2) * (($time_in > $time_out) ? -1 : 1);
        

        return $hours;
    }

    private function validateDate($date, $format = 'Y-m-d H:i:s')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
}
