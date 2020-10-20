<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveDayBreak extends Model
{
    public function leave_day() { return $this->belongsTo('App\leave_day', 'leave_day_id', 'leave_day_id'); }
    public function LeaveDayBreakEvents() { return $this->hasMany('App\LeaveDayBreakEvent', 'leave_day_break_id', 'leave_day_break_id'); }

    public $incrementing = false;
    protected $primaryKey = "leave_day_break_id";
    protected $fillable = ['leave_day_id','leave_day_break_id', 'apply_date','start_datetime','end_datetime','status','type','has_break'];
    //
    // protected $off_day_id = 'off_day_id';
    // protected $event_id = 'event_id';
}
