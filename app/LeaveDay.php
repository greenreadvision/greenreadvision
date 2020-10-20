<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveDay extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    public function leaveDayApply() { return $this->hasMany('App\LeaveDayApply', 'leave_day_id', 'leave_day_id'); }
    public function leaveDayBreak() { return $this->hasMany('App\leaveDayBreak', 'leave_day_id', 'leave_day_id'); }
    public $incrementing = false;
    protected $primaryKey = "leave_day_id";
    protected $fillable = ['leave_day_id', 'user_id', 'should_break', 'not_break', 'has_break'];
}
