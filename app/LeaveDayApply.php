<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveDayApply extends Model
{
    public function leave_day()
    {
        return $this->belongsTo('App\leaveDay', 'leave_day_id', 'leave_day_id');
    }
    public $incrementing = false;
    protected $primaryKey = "leave_day_apply_id";
    protected $fillable = ['leave_day_id', 'leave_day_apply_id', 'type', 'apply_date', 'content', 'status', 'should_break'];
    //
    // protected $off_day_id = 'off_day_id';
    // protected $event_id = 'event_id';
}
