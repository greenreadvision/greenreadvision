<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordReset;

class User extends Authenticatable
{
    use Notifiable;
    const STATUS_Resign = 'resign';
    public function invoices()
    {
        return $this->hasMany('App\Invoice', 'user_id', 'user_id')->orderby('created_at', 'desc');
    }
    public function purchases()
    {
        return $this->hasMany('App\Purchase', 'user_id', 'user_id');
    }

    public function todoRecords()
    {
        return $this->hasMany('App\TodoRecord', 'user_id', 'user_id');
    }
    public function projects()
    {
        return $this->hasMany('App\Project', 'user_id', 'user_id');
    }
    public function todos()
    {
        return $this->hasMany('App\Todo', 'user_id', 'user_id');
    }
    public function offDays()
    {
        return $this->hasMany('App\OffDay', 'user_id', 'user_id');
    }
    public function letters()
    {
        return $this->hasMany('App\Letters', 'user_id', 'user_id')->orderby('created_at', 'desc');
    }
    public function leaveDay()
    {
        return $this->hasOne('App\LeaveDay', 'user_id', 'user_id');
    }
    public function boards()
    {
        return $this->hasMany('App\Board', 'user_id', 'user_id')->orderby('created_at', 'desc');
    }
    public function goods()
    {
        return $this->hasMany('App\Goods', 'goods_id', 'goods_id');
    }

    public function projectSop()
    {
        return $this->hasMany('App\ProjectSOP', 'user_id', 'user_id');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordReset($token));
    }

    public $incrementing = false;
    protected $primaryKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', //員工編號
        'name', //姓名
        'photo',//頭貼
        'EN_name', //英文名字
        'nickname', //綽號
        'sex', //性別
        'birthday', //生日
        'email',//信箱
        'work_position', //職稱
        'role', //職位
        'ID_photo', //證件照
        'contact_person_name_1', //緊急聯絡人1
        'contact_person_phone_1', // 緊急聯絡電話1
        'contact_person_name_2', //緊急聯絡人2
        'contact_person_phone_2', // 緊急聯絡電話2
        'phone', //聯絡電話
        'celephone', //行動電話
        'is_marry', //婚姻狀況
        'ID_number', //身分證字號
        'residence_address', //戶籍地址
        'contact_address', //聯絡地址
        'IDcard_front_path', //身分證正面
        'IDcard_back_path', //身分證反面
        'healthCard_front_path', //健保卡正面
        'healthCard_back_path', //健保卡正面
        'account', //帳號
        'password', //密碼
        'bank', //銀行名稱
        'bank_branch', //銀行分行
        'bank_account_number', //銀行帳號
        'bank_account_name', //銀行戶名
        'arrival_date', //到職日期
        'status'
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
