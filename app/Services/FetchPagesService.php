<?php

namespace App\Services;

use App\Models\Path;
use App\Services\CurlService;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

class FetchPagesService
{
    public function parsePages($callback, $startFrom = 0)
    {
        $curlService = CurlService::app(Config::get('curl.url.domain'))
            ->getCookie('cookie.txt')
            ->add_header('Content-Type: application/x-www-form-urlencoded');

        $paths = Path::all();

        foreach ($paths as  $path) {
            if ($path->id < $startFrom) {
                continue;
            }
            try {
                $data = $curlService->request("/firmwares/$path->path");
                if (isset($data['html'])) {
                    $crawler = new Crawler($data['html']);
                    $h1Value = $crawler->filter('h1.text-truncate')->text();
                    $col7Values = $crawler->filter('.col-7')->each(function (Crawler $node, $i) {
                        return $node->text(); // Получаем текст из каждого элемента
                    });
                    $table = $crawler->filter('table.table')->html();
                } else {
                    $h1Value = null;
                    $col7Values = [];
                    $table = null;
                }
            } catch (\InvalidArgumentException $e) {

                echo "\n Произошло исключение id=$path->id " . $e->getMessage() . PHP_EOL;

                $h1Value = null;
                $col7Values = [];
                $table = null;
            }
            // Освобождаем память
            unset($data, $crawler);
            $insertedRow = DB::table('firmware')->insert([
                'path_id' => $path->id,
                'title' => $h1Value,
                'size' => isset($col7Values[0]) ? (int) $col7Values[0] : null,
                'date' => isset($col7Values[1]) ? $col7Values[1] : null,
                'extension' => isset($col7Values[2]) ? $col7Values[2] : null,
                'platform' => isset($col7Values[3]) ? $col7Values[3] : null,
                'crc32' => isset($col7Values[4]) ? $col7Values[4] : null,
                'data' => $table
            ]);
            call_user_func($callback); // Счет итераций: 1 итерация = 1 странице
        }
    }
}
