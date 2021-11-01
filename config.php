<?php

$config['auth'] = [
    'email'     => '',
    'password'  => '',
    'device_id' => '5qabbbberdi01r02y83cidu',
];

$config['channels'] = json_decode(file_get_contents(__DIR__.'/channels.json'),TRUE);

$config['token'] = "";

include __DIR__.'/helper.php';
