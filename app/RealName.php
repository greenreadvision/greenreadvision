<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RealName extends Model
{
    public $incrementing = false;

    protected $primaryKey = "real_name_id";
    protected $fillable = ['real_name_id', 'name','identity_card', 'qrcode'];
   
}
