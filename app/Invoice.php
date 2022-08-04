<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function project() { return $this->belongsTo('App\Project', 'project_id', 'project_id'); }
    public function user() { return $this->belongsTo('App\User', 'user_id', 'user_id'); }
    public function invoiceEvent() { return $this->hasOne('App\InvoiceEvent', 'invoice_id', 'invoice_id'); }

    public $incrementing = false;
    protected $primaryKey = "invoice_id";
    protected $keyType = 'string';
    protected $fillable = ['invoice_id', 'user_id', 'project_id', 'title','content', 'number','intern_name','company_name','company', 'bank', 'bank_branch', 'bank_account_number', 'bank_account_name', 'receipt', 'receipt_date', 'remuneration', 'price', 'detail_file', 'receipt_file', 'prepay', 'status','finished_id','purchase_id','reviewer'];

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
