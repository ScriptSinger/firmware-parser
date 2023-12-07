<?php

namespace App\Console\Commands;

use App\Models\CurlOption;
use App\Services\CurlService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class Crawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crawler:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse data from a website.';

    /**
     * Execute the console command.
     */
    public function handle()
    {


        $curl = CurlService::app();
        $response = $curl->request('/');

        $data['name'] = Config::get('curl.url');
        $data['options'] =  $curl->getOptions();
        CurlOption::create($data);

        // $this->info($response['html']);
        $this->info('The command was successful!');
    }
}
