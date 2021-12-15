<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gding extends Model
{

    public function project() { return $this->belongsTo('App\Project', 'project_id', 'project_id'); }


    public $incrementing = false;
    protected $fillable = ['id','num','project_id','title','aount','price','note'];
}
