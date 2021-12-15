<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessTrip extends Model
{
    public function invoice(){return $this->belongsTo('App\Invoice', 'invoice_id', 'invoice_id');}
    public function otherinvoice(){return $this->belongsTo('App\OtherInvoice', 'invoice_id', 'other_invoice_id');}
    public function User(){return $this->belongsTo('App\User', 'user_id', 'user_id');}

    protected $primaryKey = 'businessTrip_id';
    protected $table = 'business_trips';
    protected $keyType = 'string';
    protected $fillable = [
        'businessTrip_id','invoice_id','invoice_type','user_id','title','content','start_date','end_date','other_content','fare_train','fare_car','fare_other','meal_people','meal_day','meal_cost','live_people','live_day','live_cost','othercontent_1','othercontent_cost_1','othercontent_2','othercontent_cost_2','cost_total','reviewer','no','final_id'
    ];
}
