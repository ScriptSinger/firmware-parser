<?php

namespace App\Services;

class TelegramBotService
{

    public function sendPostMethod($message)
    {
        $chatId = config('telegram.const.chat_id');
        $botToken = config('telegram.const.bot_token');


        $postData = [
            'chat_id' => $chatId,
            'parse_mode' => 'html',
            'text' => $message,
        ];


        $endPoint = "https://api.telegram.org";

        // $request = "/bot{$botToken}/sendMessage?chat_id={$chatId}&parse_mode=html&text={$txt}";

        $requestUrl = "/bot{$botToken}/sendMessage";


        $response = CurlService::app($endPoint)
            ->add_header('Content-Type: application/x-www-form-urlencoded')
            ->post($postData)
            ->request($requestUrl);

        return $response['headers']['start'];
    }
}
