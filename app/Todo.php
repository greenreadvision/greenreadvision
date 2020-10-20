<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    public function project() { return $this->belongsTo('App\Project', 'project_id', 'project_id'); }
    public function todoEvent() { return $this->hasOne('App\TodoEvent', 'todo_id', 'todo_id'); }

    public $incrementing = false;
    protected $primaryKey = "todo_id";
    protected $fillable = ["todo_id", "project_id", "user_id", "name", "color","content", "deadline", "finished"];

    //
    // protected $todo_id = "todo_id";
    // protected $project_id = "project_id";
    // protected $user_id = "user_id";
    // protected $name = "name";
    // protected $content = "content";
    // protected $deadline = "deadline";
    // protected $finished = "finished";
}
