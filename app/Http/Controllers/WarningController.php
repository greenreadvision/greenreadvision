<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;

class WarningController extends Controller
{
    //
    public function send()
    {
        // 收件者務必使用 collect 指定二維陣列，每個項目務必包含 "name", "email"
        $to = collect([
            ['name' => 'test', 'email' => '105590028@grv.com.tw']
        ]);

        // 若要直接檢視模板
        // echo (new Warning($data))->render();die;

        // Mail::to($to)->send(new Warning($params));
        // Mail::send('pm.emails.warning', ['key' => 'value'], function($message)
        // {
        //     $message->to('105590028@grv.com.tw', '')->subject('Welcome!');
        // });
        // Mail::raw('Text to e-mail', function ($message) {
        //     $message->from('greenreadvision2020@gmail.com', 'greenreadvision');
        //     $message->to('105590028@grv.com.tw');
        // });
        return view('pm.emails.warning');
    }
}
