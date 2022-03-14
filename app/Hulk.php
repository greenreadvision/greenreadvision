<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hulk extends Model
{
    public $incrementing = false;
    
    protected $primaryKey = "id";
    protected $keyType = 'integer';
    protected $fillable = [
        'id' ,
        'sex', //性別
        'area', //地區
        'age', //性別

    ];
}
