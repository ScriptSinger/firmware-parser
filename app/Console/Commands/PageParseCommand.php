<?php

namespace App\Console\Commands;

use App\Services\FetchPagesService;
use Illuminate\Console\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;


class PageParseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parse:pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(FetchPagesService $fetchPagesService)
    {


        $output = new ConsoleOutput();
        $progressBar = new ProgressBar($output);

        $progressBar->setFormat('verbose');
        $progressBar->start();

        $fetchPagesService->parsePages(function () use ($progressBar) {
            $progressBar->advance();
        });

        $progressBar->finish();
        $this->info("\ndone");
    }
}
