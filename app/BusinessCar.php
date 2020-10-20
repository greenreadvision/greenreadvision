<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessCar extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    public function project() { return $this->belongsTo('App\Project', 'project_id', 'project_id'); }
    public $incrementing = false;
    protected $primaryKey = "business_car_id";
    protected $fillable = ['business_car_id', 'user_id','project_id', 'content', 'driver', 'phone_number', 'begin_location','end_location', 'begin_date','begin_time', 'end_date', 'end_time', 'begin_mileage','end_mileage','oil','payer'];
   
}
