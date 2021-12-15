<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seal extends Model
{
    //public function 名稱() {return $this->belongsTo('App\model名稱', 'fillable名稱', '關係名稱'); }
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    public function seal_user() { return $this->belongsTo('App\User', 'seal_user_id', 'user_id'); }
    public function project() { return $this->belongsTo('App\Project', 'project_id', 'project_id'); }

    protected $primaryKey = "seal_id";
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        "seal_id","user_id","seal_type","number","file_type","file_other_content","object","project_id","company","content","seal_user_id","final_id",'create_day','complete_day','contract_first_date','contract_end_date',"managed","complete","status"
    ];
}
