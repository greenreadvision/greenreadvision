<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    public function project() { return $this->belongsTo('App\Project', 'project_id', 'project_id'); }
    public function purchaseItem() { return $this->hasmany('App\PurchaseItem', 'purchase_id', 'purchase_id'); }

    public $incrementing = false;
    protected $primaryKey = "purchase_id";
    protected $keyType = 'string';
    protected $fillable = ['purchase_id', 'user_id','no','id', 'project_id','company_name', 'company', 'contact_person','phone','fax', 'applicant', 'purchase_date', 'delivery_date', 'address', 'note', 'amount', 'total_amount', 'tex'];

    // protected $invoice_id = "invoice_id";
    // protected $user_id = "user_id";
    // protected $project_id = "project_id";
    // protected $content = "content";
    // protected $company = "company";
    // protected $bank = "bank";
    // protected $bank_branch = "bank_branch";
    // protected $bank_account_number = "bank_account_number";
    // protected $bank_account_name = "bank_account_name";
    // protected $receipt = "receipt";
    // protected $receipt_date = "receipt_date";
    // protected $remuneration = "remuneration";
    // protected $price = "price";
    // protected $receipt_file = "receipt_file";
    // protected $detail_file = "detail_file";
    // protected $status = 'status';
    // protected $matched = 'matched';
    // protected $managed = 'managed';
    // protected $finished_id = '';
}
