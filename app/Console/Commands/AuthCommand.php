<?php

namespace App\Console\Commands;

use App\Services\AuthService;
use Illuminate\Console\Command;

class AuthCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(AuthService $authService)
    {
        $target = $this->ask('Введите URL-адрес цели (без "/" в конце) для установки куки в парсер');
        $login = $this->ask('Введите логин');
        $password = $this->secret('Введите пароль');
        $array = [
            'login' => $login,
            'password' => $password
        ];

        $response = $authService->login($target, $array);

        $this->info($response);
    }
}
