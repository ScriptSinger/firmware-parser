<?php

namespace App\Console\Commands;

use App\Services\PostService;
use Illuminate\Console\Command;

class PostCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'post:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(PostService $postService)
    {
        $response = $postService->send();
        $this->info($response);
    }
}
