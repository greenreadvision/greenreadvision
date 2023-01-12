<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OtherBillPayment extends Model
{
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    // public function project() { return $this->belongsTo('App\Project', 'project_id', 'project_id'); }
    // public function invoiceEvent() { return $this->hasOne('App\InvoiceEvent', 'invoice_id', 'invoice_id'); }

    public $incrementing = false;
    protected $primaryKey = "other_payment_id";
    protected $keyType = 'string';
    protected $fillable = ['other_payment_id','user_id','intern_name','type','company_name','number','title','content','receipt','receipt_date','remuneration','price','receipt_file','detail_file','status','matched','managed','finished_id','purchase_id','remittance_date','reviewer'];

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
