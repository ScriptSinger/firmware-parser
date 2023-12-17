<?php

namespace App\Console\Commands;

use App\Services\FileFetchProcessor;
use Illuminate\Console\Command;

class DownloadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:download';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(FileFetchProcessor $fileFetchProcessor)
    {
        $response = $fileFetchProcessor->download();
        $this->info($response);
    }
}
