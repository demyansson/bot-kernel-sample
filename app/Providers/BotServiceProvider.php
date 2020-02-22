<?php

namespace App\Providers;

use App\BotKernel\Bot;
use App\BotKernel\Handlers\SetContact;
use App\BotKernel\Handlers\SetName;
use App\BotKernel\Handlers\Start;
use App\BotKernel\MessengerContexts\IMessengerContext;
use App\BotKernel\User\EloquentUserManager;
use App\BotKernel\User\IBotUserManager;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Telegram\Bot\Objects\Contact;

class BotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->bind(IBotUserManager::class, function () {
            return new EloquentUserManager();
        });

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

        $bot
            ->addHandler(Start::class, '/start')
            ->addHandler(SetName::class, true, 'set_name')
            ->addHandler(SetContact::class, function (IMessengerContext $messenger) {
                return $messenger->get('contact') instanceof Contact;
            }, 'set_contact');

        Log::info('Bot is configured');

    }
}
