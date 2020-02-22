<?php

namespace App\BotKernel\Handlers;

use App\BotKernel\MessengerContexts\IMessengerContext;
use App\Telegram\Repositories\UserRepository;
use Telegram\Bot\Keyboard\Keyboard;
use Telegram\Bot\Objects\Contact;

class SetContact implements IMessageHandler
{
    public function handle(IMessengerContext $messenger)
    {
        $contact = $messenger->get('contact');

        resolve(UserRepository::class)->update($messenger->getUser(), [
            'phone' => $contact->getPhoneNumber()
        ]);

        $inlineKeyboard = [[]];

        foreach (range(1, 3) as $item){
            $inlineKeyboard[0][] = [
                'text' => $item,
                'callback_data' => $item
            ];
        }

        $messenger->getUserManager()->setContext('set_category');

        $messenger->set('keyboard', Keyboard::make([
            'inline_keyboard' => $inlineKeyboard,
            'resize_keyboard' => true
        ]));

        return 'Отлично! А теперь выбери к какой категории пользователей тебя отнести:';
    }
}
