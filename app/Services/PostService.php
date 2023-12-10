<?php

namespace App\Services;

class PostService
{



    public function send()
    {

        $array = ['text' => 'Возможно да, а возможно нет'];

        $curlService = CurlService::app('https://texnomag.ru')

            ->getCookie('cookie.txt')
            ->post($array);

        for ($i = 22926; $i < 23026; $i++) {
            $curlService->request("/comments/add_forum/$i");
        }

        return 'done';
    }
}
