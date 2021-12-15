<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Board extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    public function editor() { return $this->hasOne('App\Ckeditor', 'board_id', 'board_id');}
    public $incrementing = false;
    protected $primaryKey = "board_id";
    protected $fillable = ['board_id','user_id','title', 'number', 'newTypes','sticky', 'content', 'link','updata_date'];

}
