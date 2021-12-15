<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupActive extends Model
{
    public function group() { return $this->belongsTo('App\Group', 'group_id', 'group_id'); }

    protected $table ='group_actives';

    protected $fillable = ['group_id','projectName','activeName'];
}
