<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }

    public $incrementing = false;

    protected $primaryKey = "intern_id";
    protected $keyType = 'string';
    protected $fillable = [
        'intern_id', //ID
        'user_id', //使用者ID
        'name', //姓名
        'nickname', //暱稱
        'email', //電郵

    ];
}
