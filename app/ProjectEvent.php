<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectEvent extends Model
{
    public function project() { return $this->belongsTo('App\Project', 'project_id', 'project_id'); }
    public function event() { return $this->hasOne('App\Event', 'event_id', 'event_id'); }

    protected $fillable = ['project_id', 'event_id'];
    //
    // protected $project_id = 'project_id';
    // protected $event_id = 'event_id';
}
