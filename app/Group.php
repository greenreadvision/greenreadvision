<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{

    public function project() { return $this->belongsTo('App\Project', 'project_id', 'project_id'); }
    public $incrementing = false;
    protected $primaryKey = "group_id";
    protected $keyType = 'string';
    protected $fillable = ['group_id','name','phone','telephone','simpleContent','content','address','type','item_type','fax','webAddress'];

}
