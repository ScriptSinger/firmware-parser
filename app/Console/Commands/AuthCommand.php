<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AuthService;
use Illuminate\Support\Facades\Config;

class AuthCommand extends Command
{
    protected $signature = 'parser:auth {--config= : Название конфигурации (например, curl)}';
    protected $description = 'Command description';

    public function handle(AuthService $authService)
    {
        if ($this->option('config')) {
            $config = $this->loadConfig();
        } else {
            $config['url']['domain'] = $this->ask('Введите домен (например, https://site.ru):');
            $config['url']['path'] = $this->ask('Введите путь (например, /login):');
            $config['credentials']['login'] = $this->ask('Введите логин:');
            $config['credentials']['password'] = $this->secret('Введите пароль:');
        }
        $response = $authService->login($config);
        $this->info($response);
    }

    private function loadConfig()
    {
        return Config::get($this->option('config'));
    }
}
