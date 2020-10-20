<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }

    public function photoEvents() { return $this->hasMany('App\PhotosEvent', 'photo_id', 'photo_id'); }

    public $incrementing = false;
    protected $primaryKey = "photo_id";
    protected $fillable = ['photo_id', 'user_id', 'name', 'type','path'];
}
