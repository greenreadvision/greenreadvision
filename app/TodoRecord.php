<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TodoRecord extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }


    protected $fillable = ['id', 'user_id','title','event','status','finish'];
    //
    // protected $todo_id = 'todo_id';
    // protected $event_id = 'event_id';
}
