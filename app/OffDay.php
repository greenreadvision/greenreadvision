<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OffDay extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    public function offDayEvents() { return $this->hasMany('App\OffDayEvent', 'off_day_id', 'off_day_id'); }

    public $incrementing = false;
    protected $primaryKey = "off_day_id";
    protected $keyType = 'string';
    protected $fillable = ['off_day_id', 'user_id', 'type', 'start_datetime', 'end_datetime', 'status'];

    // protected $off_day_id = "off_day_id";
    // protected $user_id = "user_id";
    // protected $type = "type";
    // protected $start_datetime = "start_datetime";
    // protected $end_datetime = "end_datetime";
}
