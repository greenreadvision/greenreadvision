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
        'number',           //數量
        'unit',             //單位
        'main_category',    //分類名稱
        'storage_location', //存放位置
        'cabinet_number',   //櫃子編號
        'image_route',
        'tag'               //關鍵字
    ];
}
