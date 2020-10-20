<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Letters extends Model
{
    //
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }

    public $incrementing = false;
    protected $primaryKey = "letter_id";
    protected $fillable = ['letter_id', 'user_id', 'title','reason','content', 'link','status'];
}
