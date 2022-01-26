<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    public function project() { return $this->belongsTo('App\Project', 'project_id', 'project_id'); }
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    public function item() { return $this->hasMany('App\Estimate_item','estimate_id','estimate_id');}
    public function customer(){ return $this->belongsTo('App\Customer','customer_id','id');}

    public $incrementing = false;
    protected $primaryKey = "estimate_id";
    protected $keyType = 'string';
    protected $fillable =[
        'estimate_id',  //ID
        'no',           //計算final_id
        'final_id',     //單子編號
        'company_name', //報價公司名稱
        'user_id',      //使用者ID
        'customer_id',  //商家ID
        'project_id',   //專案ID
        'active_title',
        'active_name',  //活動名稱
        'total_price',  //報價總金額
        'account_date', //合約達成日期
        'account_file', //報價單回傳PDF
        'padding_date', //確定付款日期
        'padding_file', //付款證明
        'status',        //狀態(waitting已報價、running合約已達成、padding對方已付款)
        'receipt_date',   //我方發票開過去的ID
        'receipt_file' //發票檔案PDF
                
    ];
}
