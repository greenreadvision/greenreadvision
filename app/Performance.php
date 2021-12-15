<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Performance extends Model
{
    public function project(){return $this->belongsTo('App\Project', 'Project_id', 'Project_id'); }

    public $incrementing = false;
    protected $primaryKey = "performance_id";
    protected $fillable = ['performance_id', 'project_id', 'deposit', 'invoice_id','invoice_finished_id','deposit_file','deposit_date','PayBack_date','PayBack_file'];
}
