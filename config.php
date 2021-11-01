<?php

$config['auth'] = [
    'email'     => 'con9799@mail.ru',
    'password'  => '19970623m',
    'device_id' => '5hdeeeeerdi00r01y82cidu',
];

$config['channels'] = json_decode(file_get_contents(__DIR__.'/channels.json'),TRUE);

$config['token'] = "";

include __DIR__.'/helper.php';