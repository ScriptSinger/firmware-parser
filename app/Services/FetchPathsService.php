<?php

namespace App\Services;

use App\Models\Path;
use App\Services\CurlService;
use Illuminate\Support\Facades\Config;
use Symfony\Component\DomCrawler\Crawler;

class FetchPathsService
{
    public function parsePagesAndInsertPaths($callback)
    {

        $curl = CurlService::app(Config::get('curl.url'));
        $lastPage = $this->fetchLastPageNumber();
        $paths = [];
        for ($i = 0; $i < $lastPage; $i++) {
            $response = $curl->request("/page/$i");
            $paths = array_merge($paths, $this->getLinksFromPage($response['html'])); // объединяем массивы в один массив

            call_user_func($callback); // Счет итераций: 1 итерация = 1 странице
        }

        Path::insert($this->getPathArray($paths));
    }

    private function getLinksFromPage($html)
    {
        $crawler = new Crawler($html);
        $links = $crawler->filter('.list-group.mb-4 a');

        foreach ($links as $link) {

            $linkCrawler = new Crawler($link);
            $url = $linkCrawler->attr('href');

            // регулярное выражение для извлечения числовой части из URL-а
            preg_match('/\/(\d+)$/', $url, $matches);

            if (!empty($matches[1])) {
                $numericParts[] = (int) $matches[1];
            }
        }

        return $numericParts;
    }

    private function fetchLastPageNumber()
    {
        $curl = CurlService::app(Config::get('curl.url'));
        $response = $curl->request("/");
        $crawler = new Crawler($response['html']);
        $lastPageLink = $crawler->filter('.pagination a.page-link')->last();
        $pageUrl = $lastPageLink->attr('href');
        $parts = explode('=', $pageUrl);
        $lastPageNumber = (int) end($parts);

        return $lastPageNumber;
    }

    private function getPathArray($paths)
    {
        // Преобразование массива в массив ассоциативных массивов с полем 'path'
        return array_map(function ($value) {
            return ['path' => $value];
        }, $paths);
    }
}
