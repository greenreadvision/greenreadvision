<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    public $incrementing = false;
    protected $primaryKey = "id";
    protected $fillable = ['id','name','type', 'phone', 'email', 'intro', 'note'];

}
