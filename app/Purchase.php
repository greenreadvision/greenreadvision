<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    public function project() { return $this->belongsTo('App\Project', 'project_id', 'project_id'); }
    public function purchaseItem() { return $this->hasmany('App\PurchaseItem', 'purchase_id', 'purchase_id'); }
    public function goods() { return $this->hasmany('App\Goods', 'purchase_id', 'purchase_id')->orderby('created_at','desc'); }

    public $incrementing = false;
    protected $primaryKey = "purchase_id";
    protected $keyType = 'string';
    protected $fillable = ['purchase_id', 'user_id','no','id', 'title','project_id','company_name', 'company', 'contact_person','phone','fax', 'applicant', 'purchase_date', 'delivery_date', 'address', 'note', 'amount', 'total_amount', 'tex','is_apply_money','is_fill_good'];

}
