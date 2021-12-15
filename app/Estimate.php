<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estimate extends Model
{
    public function project() { return $this->belongsTo('App\Project', 'project_id', 'project_id'); }
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }

    public $incrementing = false;
    protected $primaryKey = "estimate_id";
    protected $keyType = 'string';
    protected $fillable =['estimate_id','no','final_id','user_id','customer_id','project_id','content','price','account_date','account_file','padding_date','staus','receipt_id','receipt_file','register','padding'];
}
