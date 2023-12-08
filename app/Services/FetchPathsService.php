<?php

namespace App\Services;

use App\Models\Path;
use App\Services\CurlService;
use Symfony\Component\DomCrawler\Crawler;

class FetchPathsService
{
    public function parsePagesAndInsertPaths($callback)
    {
        $curl = CurlService::app();
        $lastPage = $this->fetchLastPageNumber();
        $paths = [];
        for ($i = 0; $i < $lastPage; $i++) {
            $response = $curl->request("/page/$i");
            $paths = array_merge($paths, $this->getLinksFromPage($response['html'])); // объединяем массивы в один массив

            call_user_func($callback); // Счет итераций: 1 итерация = 1 странице
            // break;
        }
        Path::insert($this->getPathArray($paths));
    }

    private function getLinksFromPage($html)
    {
        $crawler = new Crawler($html);
        $links = $crawler->filter('.list-group.mb-4 a');

        $urls = [];
        foreach ($links as $link) {

            $linkCrawler = new Crawler($link);
            $urls[] = $linkCrawler->attr('href');
        }

        return $urls;
    }

    private function fetchLastPageNumber()
    {
        $curl = CurlService::app();
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
