<?php

namespace App\BotKernel\Handlers;

use App\BotKernel\MessengerContexts\IMessengerContext;
use App\Telegram\Repositories\UserRepository;

class Feedback implements IMessageHandler
{

    public function handle(IMessengerContext $messenger)
    {
        resolve(UserRepository::class)->update($messenger->getUser(), [
            'feedback' => $messenger->getMessage()
        ]);

        $messenger->getUserManager()->setContext('finish');

        return 'Спасибо';
    }
}
