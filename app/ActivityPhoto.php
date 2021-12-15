<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityPhoto extends Model
{
    public function activity(){ return $this->belongsTo('App/Activity','activity_id','connect_id');}

    protected $primaryKey = 'connect_id';
    protected $table = 'activity_photo';
    protected $keyType = 'string';
    protected $fillable =[
        'photo_id ','connect_id','name','file_address'
    ];
}
