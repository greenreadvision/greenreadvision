<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectSOP extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    public function sopitem(){return $this->hasMany('App\ProjectSOP_item','projectSOP_id','projectSOP_id');}
    public function project(){return $this->belongsTo('App\Project','project_id','project_id');}

    public $incrementing = false;
    protected $primaryKey = "projectSOP_id";
    protected $table = "project_sop";
    protected $keyType = 'string';
    protected $fillable = ['projectSOP_id','user_id','SOPtype','company_name','type','content','project_id','item_num'];
}
