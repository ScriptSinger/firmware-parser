<?php

namespace App\Services;

use App\Models\Path;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;

class FileFetchProcessor
{
    public function download()
    {
        $paths = Path::all()->pluck('path')->toArray();
        $i = 0;
        foreach ($paths as $path) {

            $curlService = CurlService::app(Config::get('curl.url.domain'))
                ->getCookie('cookie.txt')
                ->add_header('Content-Type: application/x-www-form-urlencoded')
                ->post(['id' => $path]);

            $data = $curlService->request("/firmwares/$path");

            $name = $data['headers']['content-disposition'] ?? null;

            if ($name !== null) {
                $name = $this->getFileName($name);
                $path = Storage::disk('public')->put("firmwares_example/" . $name, $data['html']);
                $i++;
                dump($i, $name);
            }
            break;
        }
    }

    private function getFileName($attachmentHeader)
    {
        return explode('=', $attachmentHeader, 2)[1];
    }
}
