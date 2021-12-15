<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectSOP_item extends Model
{
    public function projectSOP(){return $this->belongsTo('App\ProjectSOP','projectSOP_id','projectSOP_id');}
    protected $table = "project_sop_item";
    protected $fillable = ['projectSOP_id','name','file_address','content','no'];
}
