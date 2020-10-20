<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    public $incrementing = false;
    protected $primaryKey = "bank_id";
    protected $fillable = ['bank_id','name', 'bank_account_name', 'bank', 'bank_branch','bank_account_number'];
}
