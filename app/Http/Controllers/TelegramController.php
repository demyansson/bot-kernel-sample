<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Api;

class TelegramController extends Controller
{
    /**
     * @var Api
     */
    private $telegram;

    public function __construct(Api $telegram)
    {
        $this->telegram = $telegram;
    }

    /**
     * Set up webhook
     *
     * @return Response
     * @throws \Telegram\Bot\Exceptions\TelegramSDKException
     */
    public function setupWebhook()
    {
        $response = $this->telegram->setWebhook([
            'url' => route('telegram.update')
        ]);

        return new Response($response->getBody());
    }

    /**
     * Incoming telegram update
     */
    public function update()
    {
        $update = $this->telegram->getWebhookUpdate();

        Log::debug(file_get_contents('php://input'));
    }
}
