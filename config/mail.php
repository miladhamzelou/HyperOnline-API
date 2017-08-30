<?php

return [
    'driver' => env('MAIL_DRIVER', 'smtp'),
    'host' => env('MAIL_HOST', 'smtp.gmail.com'),
    'port' => env('MAIL_PORT', 587),
    'from' => [
        'address' => env('MAIL_FROM_ADDRESS', 'hyperonlineir@gmail.com'),
        'name' => env('MAIL_FROM_NAME', 'hyperonlineir'),
    ],
    'encryption' => env('MAIL_ENCRYPTION', 'tls'),
    'username' => "hyperonlineir@gmail.com",
    'password' => "jfmdqgsegeuvjmko",
    'sendmail' => '/usr/sbin/sendmail -bs',
    'markdown' => [
        'theme' => 'default',
        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],
];