<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PhotosEvent extends Model
{
    public function photo() { return $this->belongsTo('App\Photos', 'photo_id', 'photo_id'); }

    protected $fillable = ['image_id','photo_id', 'path'];
}
