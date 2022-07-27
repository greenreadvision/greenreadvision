<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    public function project() { return $this->belongsTo('App\Project', 'project_id', 'project_id'); }
    public function project_user(){return $this->belongsTo('App\User', 'project_user_id', 'user_id');}
    public function photo() { return $this->hasMany('App\ActivityPhoto','activity_id','activity_id');}
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    public function activityType(){ return $this->belongsTo('App\ActivityType', 'type_id', 'type_id');}

    public $incrementing = false;
    protected $primaryKey = "activity_id";
    protected $fillable = ['activity_id','organizers','name','type','content','project_id','project_user_id','user_id','begin_time','end_time','img_path'];

}
