<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Change extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }

    public $incrementing = false;
    protected $primaryKey = "id";
    protected $keyType = 'string';
    protected $fillable = ['id', 'user_id','intern_name', 'change_type', 'title', 'content', 'file', 'urgency', 'status', 'matched', 'finished_id', 'managed', 'finished_date', 'finished_message', 'withdraw_reason'];
}
