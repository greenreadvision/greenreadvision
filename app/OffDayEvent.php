<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OffDayEvent extends Model
{
    public function off_day() { return $this->belongsTo('App\off_day', 'off_day_id', 'off_day_id'); }
    public function event() { return $this->hasOne('App\Event', 'event_id', 'event_id'); }

    protected $fillable = ['off_day_id', 'event_id'];
    //
    // protected $off_day_id = 'off_day_id';
    // protected $event_id = 'event_id';
}
