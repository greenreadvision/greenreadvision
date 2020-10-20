<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveDayBreakEvent extends Model
{
    public function leave_day_break() { return $this->belongsTo('App\leave_day_break', 'leave_day_break_id', 'leave_day_break_id'); }
    public function event() { return $this->hasOne('App\Event', 'event_id', 'event_id'); }

    protected $fillable = ['leave_day_break_id', 'event_id'];
    //
    // protected $off_day_id = 'off_day_id';
    // protected $event_id = 'event_id';
}
