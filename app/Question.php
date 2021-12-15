<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    
    protected $table ='question';

    public $incrementing = false;
    protected $primaryKey = "question_id";
    protected $fillable = [
        "question_id","user_id","title","option_1","option_2","option_3","option_4","type","answer","content"
    ];
}
