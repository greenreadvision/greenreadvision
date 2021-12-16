<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    public function todos() { return $this->hasMany('App\Todo', 'project_id', 'project_id'); }
    public function invoices() { return $this->hasMany('App\Invoice', 'project_id', 'project_id'); }
    public function gding(){return $this->hasMany('App\Gding','project_id','project_id');}
    public function projectSOP(){return $this->hasMany('App\ProjectSOP','project_id','project_id');}
    public function purchases() { return $this->hasMany('App\Purchase', 'purchase_id', 'purchase_id'); }
    public function projectEvents() { return $this->hasMany('App\ProjectEvent', 'project_id', 'project_id'); }
    public function acceptances() { return $this->hasMany('App\Acceptance','project_id','project_id');}
    public function defaults() { return $this->hasMany('App\DefaultItem','project_id','project_id');}
    public function performance() { return $this->hasOne('App\Performance','performance_id','performance_id');}

    public $incrementing = false;
    protected $primaryKey = "project_id";
    protected $fillable = ['project_id', 'user_id','company_name', 'name', 'beginning_date', 'deadline_date', 'deadline_time','open_date', 'open_time','closing_date', 'contract_value','case_num','default_fine', 'color', 'status','estimated_cost','estimated_profit','actual_cost','actual_profit','effective_interest_rate','receiver','acceptance_times','default_num','performance_id','income_statement'];
    //
    // protected $project_id = "project_id";
    // protected $user_id = "user_id";
    // protected $name = "name";
    // protected $beginning_date = "beginning_date";
    // protected $deadline_date = "deadline_date";
    // protected $closing_date = "closing_date";
    // protected $bid_bound = "bid_bound";
    // protected $case_num = "case_num";
    // protected $default_fine = "default_fine";
    // protected $total_amount = "total_amount";
    // protected $estimated_cost = "estimated_cost";
    // protected $estimated_profit = "estimated_profit";
    // protected $actual_cost = "actual_cost";
    // protected $actual_profit = "actual_profit";
    // protected $effective_interest_rate = "effective_interest_rate";
    // protected $color = "color";
    // protected $finished = "finished";
}
