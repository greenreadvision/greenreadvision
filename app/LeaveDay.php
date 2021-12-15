<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LeaveDay extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    public function leaveDayApply() { return $this->hasMany('App\LeaveDayApply', 'leave_day_id', 'leave_day_id')->orderby('apply_date','desc'); }
    public function leaveDayBreak() { return $this->hasMany('App\LeaveDayBreak', 'leave_day_id', 'leave_day_id')->orderby('apply_date','desc'); }
    public $incrementing = false;
    protected $primaryKey = "leave_day_id";
    protected $fillable = ['leave_day_id', 'user_id'];
}
