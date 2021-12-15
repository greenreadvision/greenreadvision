<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveDayBreak extends Model
{
    public function leave_day() { return $this->belongsTo('App\leaveDay', 'leave_day_id', 'leave_day_id'); }
    public function LeaveDayBreakEvents() { return $this->hasMany('App\LeaveDayBreakEvent', 'leave_day_break_id', 'leave_day_break_id'); }

    public $incrementing = false;
    protected $primaryKey = "leave_day_break_id";
    protected $fillable = ['leave_day_id','leave_day_break_id', 'apply_date','status','content','types','type','prove','has_break'];
    //
    // protected $off_day_id = 'off_day_id';
    // protected $event_id = 'event_id';
}
