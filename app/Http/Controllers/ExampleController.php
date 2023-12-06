<?php

namespace App\Http\Controllers;

use App\Models\CurlOption;
use App\Services\ParserService;

class ExampleController extends Controller
{
    public function createSetting()
    {
        $curl = ParserService::app('https://firmwares.texnomag.ru')
            ->set(CURLOPT_HEADER, 1) //получать заголовки в ответе
            ->set(CURLOPT_PROXY, '127.0.0.1:9085')
            ->set(CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5,)
            ->add_headers([
                'Accept: */*',
                // 'Accept-Encoding: gzip, deflate',
                'Accept-Language: ru-RU,ru;q=0.9,en-US;q=0.8,en;q=0.7',
                'Content-Type: text/plain',
                // Cookie:
                // i=yFeKJ8JVdk3MXiHnCazi7LCkBAqHvUtkjmECwx7BvkrP5cvZuCvQkGvGD1WdZ8Y/RceK0P4dJEtfBwXigYRT7D+QLBQ=; yandexuid=7255833671694768398; yuidss=7255833671694768398; ymex=2010128399.yrts.1694768399; _ym_uid=169521611451425866; _ym_d=1695216123; yashr=8629994651696358252; is_gdpr=0; my=YwA=; is_gdpr_b=CK28eRDp0wEoAg==; gdpr=0; yandex_login=lucky2strike; Session_id=3:1697808656.5.0.1697208320328:a5c71Q:87.1.2:1|560031115.0.2.3:1697208320|3:10277471.779369._qp7-0xoh0ahBWGWB5ZAhtQWcDA; sessar=1.1183.CiB70cM_5sq8foz-tldcf7urLwgx2pMfHdYjnpBGEnPZpg.JCxq6OWPqKLJeEOCt7f3RXLnJY11ifX2a2XdRJMRBAE; sessionid2=3:1697808656.5.0.1697208320328:a5c71Q:87.1.2:1|560031115.0.2.3:1697208320|3:10277471.779369.fakesign0000000000000000000; yp=2013168656.pcs.0#1700487057.hdrc.0#1712976312.szm.1%3A1920x1080%3A992x642#2012568320.udn.cDpsdWNreTJzdHJpa2U%3D; yabs-sid=2192866351701511853; bh=Ej8iR29vZ2xlIENocm9tZSI7dj0iMTE5IiwiQ2hyb21pdW0iO3Y9IjExOSIsIk5vdD9BX0JyYW5kIjt2PSIyNCIaBSJ4ODYiIhAiMTE5LjAuNjA0NS4xOTkiKgI/MDoHIkxpbnV4IkIHIjYuNi4yIkoEIjY0IlJcIkdvb2dsZSBDaHJvbWUiO3Y9IjExOS4wLjYwNDUuMTk5IiwiQ2hyb21pdW0iO3Y9IjExOS4wLjYwNDUuMTk5IiwiTm90P0FfQnJhbmQiO3Y9IjI0LjAuMC4wIiI=
                // Dnt:
                // 1
                // 'Origin: https://firmwares.texnomag.ru',
                // 'Referer: https://firmwares.texnomag.ru/',
                // 'Sec-Ch-Ua:"Google Chrome";v="119", "Chromium";v="119", "Not?A_Brand";v="24"'
                // Sec-Ch-Ua-Mobile:
                // ?1
                // Sec-Ch-Ua-Platform:
                // "Android"
                // Sec-Fetch-Dest:
                // empty
                // Sec-Fetch-Mode:
                // cors
                // Sec-Fetch-Site:
                // cross-site
                'User-Agent: Mozilla/5.0 (Linux; Android 6.0; Nexus 5 Build/MRA58N) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/119.0.0.0 Mobile Safari/537.36'
            ]);

        $options = $curl->getOptions();

        $data['name'] = "firmwares.texnomag.ru";
        $data['options'] = $options;
        CurlOption::create($data);

        // ->set(CURLOPT_FOLLOWLOCATION, true); // следование за редиректом

        // $response = $curl->request('/download');

        // dd($response);
    }
}
