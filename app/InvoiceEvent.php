<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceEvent extends Model
{
    public function invoice() { return $this->belongsTo('App\invoice', 'invoice_id', 'invoice_id'); }
    public function event() { return $this->hasOne('App\Event', 'event_id', 'event_id'); }

    protected $fillable = ['invoice_id', 'event_id'];
    //
    // protected $invoice_id = 'invoice_id';
    // protected $event_id = 'event_id';
}
