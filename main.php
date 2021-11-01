<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-type: application/text");
//header ("Content-Type: application/vnd.apple.mpegurl");
header ("Pragma: no-cache");
header ("Expires: 0");

include __DIR__.'/config.php';

$uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
if (array_key_exists('1', $uri_parts) && array_key_exists($uri_parts['1'], $config['channels'])) {
    getChannel($uri_parts['1']);
}else{
    echo "#EXTM3U";
}