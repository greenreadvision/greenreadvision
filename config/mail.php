<?php

return [
    // 'driver' => env('MAIL_DRIVER', 'smtp'),

    // 'host' => env('MAIL_HOST', 'smtp.mailgun.org'),

    // 'port' => env('MAIL_PORT', 587),

    // 'from' => [
    //     'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
    //     'name' => env('MAIL_FROM_NAME', 'Example'),
    // ],

    // 'encryption' => env('MAIL_ENCRYPTION', 'tls'),

    // 'username' => env('MAIL_USERNAME'),

    // 'password' => env('MAIL_PASSWORD'),

    // 'sendmail' => '/usr/sbin/sendmail -bs',

    // 'markdown' => [
    //     'theme' => 'default',

    //     'paths' => [
    //         resource_path('views/vendor/mail'),
    //     ],
    // ],
    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.gmail.com'),
    'port' => env('MAIL_PORT', 587),
    'from' => ['address' => 'greenreadvision2020@gmail.com', 'name' => 'greenreadvision'],
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    'username' => env('MAIL_USERNAME'),
    'password' => env('MAIL_PASSWORD'),
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => true
    // 'driver' => env('MAIL_DRIVER', 'smtp'),
    // 'host' => env('MAIL_HOST', 'smtp.mailgun.org'),
    // 'port' => env('MAIL_PORT', 465),
    // 'username' => env('MAIL_USERNAME'),
    // 'password' => env('MAIL_PASSWORD'),
    // 'from' => ['address' => env('MAIL_FROM_ADDRESS'), 'name' =>  env('MAIL_FROM_NAME')],
    // 'sendmail'   => '/usr/sbin/sendmail -bs'
];
