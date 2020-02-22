<?php

namespace App\BotKernel\Handlers;

use App\BotKernel\MessengerContexts\IMessengerContext;

class Start implements IMessageHandler
{

    public function handle(IMessengerContext $messenger)
    {
        return 'Привет, добро пожаловать! Я справлюсь с тестовым заданием 🙂';
    }
}
