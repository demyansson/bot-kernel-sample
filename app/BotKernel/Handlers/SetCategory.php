<?php

namespace App\BotKernel\Handlers;

use App\BotKernel\MessengerContexts\IMessengerContext;
use App\Telegram\Repositories\UserRepository;

class SetCategory implements IMessageHandler
{

    public function handle(IMessengerContext $messenger)
    {
        resolve(UserRepository::class)->update($messenger->getUser(), [
            'category' => $messenger->get('callback')->getData()
        ]);
        return 'Поздравляю, теперь пришли мне фото';

        $messenger->getUserManager()->setContext('set_photo');

    }
}
