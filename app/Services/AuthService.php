<?php

namespace App\Services;

class AuthService
{
    public function login($config)
    {
        $curlService = CurlService::app($config['url']['domain'])
            ->add_header('Content-Type: application/x-www-form-urlencoded')
            ->post($config['credentials'])
            ->setCookie('cookie.txt');

        $data = $curlService->request($config['url']['path']);
        return $data['headers']['start'];
    }
}
