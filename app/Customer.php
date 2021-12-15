<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public function bank() { return $this->hasOne('App\Bank', 'bank_id', 'bank_id'); }

    public $incrementing = false;
    protected $primaryKey = "id";
    protected $keyType = 'string';
    protected $fillable = ['id','no','bank_id','name','principal','sex','address','tax_id','customer_id','phone','fax','email'];
}
