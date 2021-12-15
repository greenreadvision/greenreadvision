<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityType extends Model
{
    public function activity() { return $this->hasMany('App\Activity', 'activity_id', 'activity_id'); }

    public $incrementing = false;
    protected $primaryKey = "type_id";
    protected $fillable = ['type_id','content'];
}
