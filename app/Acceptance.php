<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acceptance extends Model
{
    public function Project(){ return $this->belongsTo('App\project','project_id','project_id');}
    
    public $incrementing = false;
    protected $fillable = ['id','project_id','no','persen','acceptance_date'];
}
