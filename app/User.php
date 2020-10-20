<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public function invoices() { return $this->hasMany('App\Invoice', 'user_id', 'user_id')->orderby('created_at','desc'); }
    public function purchases() { return $this->hasMany('App\Purchase', 'purchase_id', 'purchase_id'); }

    public function todoRecords(){return $this->hasMany('App\TodoRecord','user_id','user_id');}
    public function projects() { return $this->hasMany('App\Project', 'user_id', 'user_id'); }
    public function todos() { return $this->hasMany('App\Todo', 'user_id', 'user_id'); }
    public function offDays() { return $this->hasMany('App\OffDay', 'user_id', 'user_id'); }
    public function letters() { return $this->hasMany('App\Letters', 'user_id', 'user_id')->orderby('created_at','desc'); }


    public $incrementing = false;
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name', 'nickname', 'role', 'email', 'password','bank','bank_branch','bank_account_number','bank_account_name','arrival_date','phone_number','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
