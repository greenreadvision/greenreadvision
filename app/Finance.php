<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Finance extends Model
{
    public function project() { return $this->belongsTo('App\Project', 'project_id', 'project_id'); }
    public function property() { return $this->hasMany('App\Property', 'finance_id', 'finance_id'); }

    public $incrementing = false;
    protected $primaryKey = "finance_id";
    protected $fillable = ['id', 'finance_id', 'project_id', 'user_id', 'date', 'name', 'price'];
    //
    // protected $finance_id = "finance_id";
    // protected $project_id = "project_id";
    // protected $user_id = "user_id";
    // protected $date = "date";
    // protected $name = "name";
    // protected $price = "price";
}
