<?php
// Created By @hoaaah * Copyright (c) 2020 belajararief.com

if(YII_ENV=='dev'){
    return [
        'class' => 'yii\db\Connection',
        'dsn' => env("DNS_TEST"),
        'username' => env("USERNAME_TEST"),
        'password' => env("PASSWORD_TEST"),
        'charset' => env("CHARSET_TEST"),
    ];
}

return [
    'class' => 'yii\db\Connection',
    'dsn' => env("DNS"),
    'username' => env("USERNAME"),
    'password' => env("PASSWORD"),
    'charset' => env("CHARSET"),
];