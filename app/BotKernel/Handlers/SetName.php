<?php

namespace App\BotKernel\Handlers;

use App\BotKernel\MessengerContexts\IMessengerContext;
use App\Telegram\Repositories\UserRepository;
use Telegram\Bot\Keyboard\Keyboard;

class SetName implements IMessageHandler
{

    public function handle(IMessengerContext $messenger)
    {
        $message = $messenger->getMessage();

        if(strlen($message) > 101){
            return 'Ваше имя слишком длинное, максимум 100 символов';
        }

        resolve(UserRepository::class)->update($messenger->getUser(), [
            'name' => $message
        ]);

        $messenger->getUserManager()->setContext('set_contact');

        $keyboard = Keyboard::make([
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ])->row(Keyboard::button([
            'text' => 'Отправить контакт',
            'request_contact' => true,
        ]));

        $messenger->set('keyboard', $keyboard);

        return 'Для начала использования отправь мне свой контакт';
    }
}
