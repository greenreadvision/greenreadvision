<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TodoEvent extends Model
{
    public function todo() { return $this->belongsTo('App\Todo', 'todo_id', 'todo_id'); }
    public function event() { return $this->hasOne('App\Event', 'event_id', 'event_id'); }

    protected $fillable = ['todo_id', 'event_id'];
    //
    // protected $todo_id = 'todo_id';
    // protected $event_id = 'event_id';
}
