<?php

return [
    'url' => 'https://firmwares.texnomag.ru/download',
    // 'url' => 'https://ufamasters.ru',

    'settings' => [
        CURLOPT_HEADER => 1, //получать заголовки в ответе
        CURLOPT_PROXY => '127.0.0.1:9085',
        CURLOPT_PROXYTYPE => CURLPROXY_SOCKS5,
        CURLOPT_FOLLOWLOCATION => true,  // следование за редиректом
        CURLOPT_REFERER => 'https://yandex.ru/',
        CURLOPT_HTTPHEADER => [
            'Accept: */*',
            'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
            'Content-Type: text/plain',
            'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Mobile Safari/537.36',
        ],
    ]
];
