<?php
namespace App\Mail;
 
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
 
class Warning extends Mailable
{
    use Queueable, SerializesModels;
 
    public $params;
 
    // 讓外部可以將參數指定進來
    public function __construct($params)
    {
        $this->params = $params;
    }
 
    public function build()
    {
        // 透過 with 把參數指定給 view
        return $this->subject("警告訊息")
            ->view('pm.emails.warning')
            ->with([
                'params' => $this->params,
            ]);
    }
}