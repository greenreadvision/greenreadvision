<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    public function purchase() { return $this->belongsTo('App\Purchase', 'purchase_id', 'purchase_id'); }

    
    protected $fillable = ['purchase_id', 'no','content', 'quantity', 'price', 'amount','note'];


}
