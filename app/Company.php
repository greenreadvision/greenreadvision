<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $incrementing = false;
    protected $primaryKey = "company_id";
    protected $fillable = ['company_id', 'number', 'name', 'address','email','phone'];
}
