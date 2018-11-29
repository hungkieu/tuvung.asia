<?php

return [
    'driver' => 'smtp',
    'host' => 'smtp.gmail.com',
    'port' => 587,
    'from' => [
        'address' => 'mimi@meohamhoc.com',
        'name' => 'meohamhoc.com',
    ],
    'encryption' => 'tls',
    'username' => 'hungkieu.h12@gmail.com',
    'password' => 'fsfcwjxzyqfywhns',
    'sendmail' => '/usr/sbin/sendmail -bs',
    'pretend' => false,
    'markdown' => [
        'theme' => 'default',
        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
