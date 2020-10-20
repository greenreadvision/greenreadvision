<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $incrementing = false;
    protected $primaryKey = "event_id";
    protected $fillable = ['event_id', 'user_id', 'project_id', 'date', 'name', 'content', 'type', 'relationship', 'relationship_id'];
    //
    // protected $event_id = "event_id";
    // protected $user_id = "user_id";
    // protected $date = "date";
    // protected $name = "name";
    // protected $content = "content";
    // protected $type = "type";
    // protected $relationship = "relationship";
}
