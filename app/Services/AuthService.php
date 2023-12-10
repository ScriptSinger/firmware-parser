<?php

namespace App\Services;

class AuthService
{
    public function login($target, $array)
    {
        $curlService = CurlService::app($target)
            ->post($array)
            ->setCookie('cookie.txt');

        $data = $curlService->request('/');
        return $data['headers']['start'];
    }
}
