<?php

namespace App\Telegram;

use App\BotKernel\Bot as BotBase;
use App\BotKernel\MessengerContexts\TelegramMessengerContext;
use App\Telegram\Services\UserService;
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
        if($message = $update->getMessage()){
            $user = $this->userService->findOrCreate($message->getFrom());

            $messenger = new TelegramMessengerContext();

            $messenger->setUser($user);
            $messenger->setMessage($message->getText());

            $answer = $this->bot->handleMessage($messenger);

            $params = [
                'chat_id' => $message->getChat()->getId(),
                'text' => $answer,
            ];

            $this->telegram->sendMessage($params);
        }
    }
}
