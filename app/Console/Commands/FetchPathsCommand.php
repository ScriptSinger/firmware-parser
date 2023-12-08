<?php

namespace App\Console\Commands;

use App\Services\FetchPathsService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class FetchPathsCommand extends Command
{
    protected $signature = 'fetch:paths';
    protected $description = 'Parse data from a website.';



    public function handle(FetchPathsService $fetchPathsService)
    {
        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output);

        $progressBar->setFormat('verbose');
        $progressBar->start();

        $fetchPathsService->parsePagesAndInsertPaths(function () use ($progressBar) {
            $progressBar->advance();
        });

        $progressBar->finish();
        $this->info("\ndone");
    }
}
