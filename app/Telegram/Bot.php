<?php

namespace App\Telegram;

use App\BotKernel\Bot as BotBase;
use App\BotKernel\MessengerContexts\TelegramMessengerContext;
use App\Telegram\Services\UserService;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\Update;

class Bot
{
    /**
     * @var Api
     */
    private $telegram;

    /**
     * @var BotBase
     */
    private $bot;

    /**
     * @var UserService
     */
    private $userService;

    public function __construct(Api $telegram, BotBase $bot, UserService $userService)
    {
        $this->telegram = $telegram;
        $this->bot = $bot;
        $this->userService = $userService;
    }

    /**
     * @param Update $update
     * @throws \Exception
     */
    public function handleUpdate(Update $update)
    {
        if(!$chat = $update->getChat()){
            return;
        }

        $messenger = new TelegramMessengerContext();

        $from = null;

        if($message = $update->getMessage()){
            Log::info('message');
            $from = $message->getFrom();

            $messenger->setMessage($message->getText());

            if($contact = $message->getContact()){
                $messenger->set('contact', $contact);
            }

            if($photo = $message->getPhoto()){
                $messenger->set('photo', $photo);
            }
        }

        if($callback = $update->getCallbackQuery()){
            Log::info('callback');

            $from = $callback->getFrom();

            $messenger->set('callback', $callback);
        }

        if ($from === null){
            return;
        }

        $user = $this->userService->findOrCreate($from);

        $messenger->setUser($user);

        $answer = $this->bot->handleMessage($messenger);

        Log::info($answer);

        if(!$answer){
            return;
        }

        $params = [
            'chat_id' => $chat->getId(),
            'text' => $answer,
        ];

        if($keyboard = $messenger->get('keyboard')){
            $params['reply_markup'] = $keyboard;
        }

        $this->telegram->sendMessage($params);
    }
}
