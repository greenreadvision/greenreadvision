<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recruit extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    protected $table ='recruit';

    public $incrementing = false;
    protected $primaryKey = "Recruit_id";
    protected $fillable = [
        "Recruit_id","user_id","user_name_CH","sex","user_name_EN","nickname","birthday","work_position","Email","contact_person_1_name","contact_person_1_phone","contact_person_2_name","contact_person_2_phone","photo_path","phone","first_day","celephone","marry","IDcard_number","residence_address","contact_address","front_of_IDcard_path","back_of_IDcard_path","front_of_healthCard_path","back_of_healthCard_path","basic_information_file","labor_file"
    ];

}
