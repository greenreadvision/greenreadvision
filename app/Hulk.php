<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hulk extends Model
{
    public $incrementing = false;
    
    protected $fillable = [
        'sex', //性別
        'area', //地區
        'age', //性別
    ];
}
