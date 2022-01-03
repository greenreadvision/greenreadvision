<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    public function purchases() { return $this->belongsTo('App\Purchase', 'purchase_id', 'purchase_id'); }

    public $incrementing = false;
    protected $primaryKey = "goods_id";
    protected $keyType = 'string';
    protected $fillable = ['goods_id', 'purchase_id','user_id', 'signer', 'receipt_date','freight_name', 'delivery_number','good_name','quantity', 'random_inspection', 'defect', 'inventory_name', 'freight_bill', 'freight_exterior', 'all_goods', 'single_good', 'defect_goods','remark'];

}
