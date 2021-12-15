<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ckeditor extends Model
{
    public function board() { return $this->belongsTo('App\Board', 'board_id', 'board_id'); }
    public $incrementing = false;
    protected $primaryKey = "editor_id";
    protected $fillable = ['editor_id', 'board_id', 'content'];
}
