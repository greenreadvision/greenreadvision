<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }

    public $incrementing = false;
    protected $primaryKey = "home_id";
    protected $keyType = 'string';
    protected $fillable = ['home_id', 'user_id', 'title', 'content'];

    // protected $off_day_id = "off_day_id";
    // protected $user_id = "user_id";
    // protected $type = "type";
    // protected $start_datetime = "start_datetime";
    // protected $end_datetime = "end_datetime";
}
