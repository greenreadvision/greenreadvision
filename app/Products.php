<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
   
    public $incrementing = false;
    protected $primaryKey = "products_id";
    protected $keyType = 'string';
    protected $fillable = ['products_id','user_id', 'name', 'order', 'url','path'];
}
