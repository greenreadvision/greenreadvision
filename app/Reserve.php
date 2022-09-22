<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    public $incrementing = false;
    protected $primaryKey = "reserve_id";
    protected $keyType = "string";
    protected $fillable = [
        'reserve_id',       //ID
        'name',             //品名
        'stock',           //數量
        'category',    //分類
        'location',      //存放位置
        'cabinet_number',   //櫃子編號
        'note',
        'signer',
        'project_id'
    ];
}