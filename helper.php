<?php

function login()
{
    global $config;
    $ch = curl_init("https://api.allplay.uz/api/v1/login");
    curl_setopt_array($ch, array(
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36',
        CURLOPT_ENCODING       => 'gzip, deflate',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_REFERER        => 'https://allplay.uz',
        CURLOPT_POSTFIELDS     => http_build_query($config['auth']),
        CURLOPT_HTTPHEADER     => array(
            'Accept: application/json',
            'Accept-Encoding: gzip, deflate, br',
            'Accept-Language: en-US,en;q=0.9,ru;q=0.8',
            'Authorization: Bearer XYsX89W7ptfpwGzBqpm7l9PurbMt7RXmpSC7HAIHnuWpZIJws3STGH3hSJFr',
            'Connection: keep-alive',
            'Host: api.allplay.uz',
            'Origin: https://allplay.uz',
            'Referer: https://allplay.uz/',
            'sec-ch-ua: "Chromium";v="92", " Not A;Brand";v="99", "Google Chrome";v="92"',
            'sec-ch-ua-mobile: ?0',
            'Sec-Fetch-Dest: empty',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Site: same-site',
            'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36',
            'X-Allplay-App: web',
            'X-Allplay-Brand: Google Inc.',
            'X-Allplay-Device-Id: 5hdeeeeerdi00r01y82cidu',
            'X-Allplay-Model: 5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36',
            'X-Allplay-OS-Version: Linux x86_64',
            'X-Allplay-Version: 1.2.2',
        ),
    ));
    $res = curl_exec($ch);
    curl_close($ch);
    $res = json_decode($res, true);
    file_put_contents(__DIR__ . '/token', $res['api_token']);
    $config['token'] = $res['api_token'];
}

function getChannel($id)
{
    global $config;
    $ch = curl_init("https://api.allplay.uz/api/v1/iptv/channel/play/" . $id);
    curl_setopt_array($ch, array(
        CURLOPT_USERAGENT      => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36',
        CURLOPT_ENCODING       => 'gzip, deflate',
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_REFERER        => 'https://allplay.uz',
        CURLOPT_HTTPHEADER     => array(
            'Accept: application/json',
            'Accept-Encoding: gzip, deflate, br',
            'Accept-Language: en-US,en;q=0.9,ru;q=0.8',
            'Authorization: Bearer ' . getToken() . '',
            'Connection: keep-alive',
            'Host: api.allplay.uz',
            'Origin: https://allplay.uz',
            'Referer: https://allplay.uz/',
            'sec-ch-ua: "Chromium";v="92", " Not A;Brand";v="99", "Google Chrome";v="92"',
            'sec-ch-ua-mobile: ?0',
            'Sec-Fetch-Dest: empty',
            'Sec-Fetch-Mode: cors',
            'Sec-Fetch-Site: same-site',
            'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36',
            'X-Allplay-App: web',
            'X-Allplay-Brand: Google Inc.',
            'X-Allplay-Device-Id: 5hdeeeeerdi00r01y82cidu',
            'X-Allplay-Model: 5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36',
            'X-Allplay-OS-Version: Linux x86_64',
            'X-Allplay-Version: 1.2.2',
        ),
    ));
    $res = curl_exec($ch);
    curl_close($ch);
    $res = json_decode($res, true);
    if (isset($res['errors']['default']['0'])) {
        if ($res['errors']['default']['0'] == "Вы не авторизованы") {
            getToken(true);
            return getChannel($id);
        } else {
            return false;
        }
    }
    return $res;
}
function getm3u8($id)
{
    $channel = getChannel($id);
    if(!isset($channel['data']['url'])){
    	return "";
    }
    if ($channel) {
        global $config;
        $ch = curl_init($channel['data']['url']);
        curl_setopt_array($ch, array(
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36',
            CURLOPT_ENCODING       => 'gzip, deflate',
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_REFERER        => 'https://allplay.uz',
            CURLOPT_HTTPHEADER     => array(
                'Accept: */*',
                'Accept-Encoding: gzip, deflate, br',
                'Accept-Language: en-US,en;q=0.9,ru;q=0.8',
                'Connection: keep-alive',
                'Host: api.allplay.uz',
                'Origin: https://allplay.uz',
                'Referer: https://allplay.uz/',
                'sec-ch-ua: "Chromium";v="92", " Not A;Brand";v="99", "Google Chrome";v="92"',
                'sec-ch-ua-mobile: ?0',
                'Sec-Fetch-Dest: empty',
                'Sec-Fetch-Mode: cors',
                'Sec-Fetch-Site: same-site',
                'User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.159 Safari/537.36'
            ),
        ));
        $res = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if ($httpcode == '403') {
        	getToken(true);
            return getm3u8($id);
        }else{
        	return $res;
        }
    }

    return "#EXTM3U";
}
function getToken($n = false)
{
    if ($n) {
        login();
    }
    if (file_exists(__DIR__ . '/token')) {
        $token           = file_get_contents(__DIR__ . '/token');
        $config['token'] = $token;
        return $token;
    } else {
        return getToken(true);
    }
}
