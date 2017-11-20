<?php

return [
    'config' => [
        'storage'    => 'file',
        'basefolder' => dirname(__DIR__) . '/storage/instagram/',
    ],
    'username' => env('INSTAGRAM_USERNAME'),
    'password' => env('INSTAGRAM_PASSWORD'),
];
