<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estimate_item extends Model
{
    public function estimate() { return $this->belongsTo('App\Estimate', 'estimate_id', 'estimate_id'); }

    public $incrementing = false;
    protected $fillable =[
        'id',
        'no',
        'estimate_id',
        'content',
        'quantity',
        'unit',
        'price',
        'amount',
        'note'
    ];
}
