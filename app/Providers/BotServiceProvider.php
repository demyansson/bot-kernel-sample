<?php

namespace App\Providers;

use App\BotKernel\Bot;
use App\BotKernel\Handlers\Start;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class BotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(Bot::class, function () {
            return new Bot();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
        $bot = $this->app->make(Bot::class);

        $bot->addHandler(Start::class, '/start');

        Log::info('Bot is configured');

    }
}
