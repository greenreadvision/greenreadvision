<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DefaultItem extends Model
{
    public function project() { return $this->belongsTo('App\Project', 'project_id', 'project_id'); }
    public $incrementing = false;
    protected $fillable = ['no','project_id','content','persen','default_date'];
}
