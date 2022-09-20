<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Intern extends Model
{
    public $incrementing = false;

    protected $primaryKey = "intern_id";
    protected $keyType = 'string';
    protected $fillable = [
        'intern_id', //ID
        'name', //姓名
        'nickname', //暱稱
        'phone', //電郵
        'status',//在職狀態
    ];
}
