<?php

namespace App\BotKernel\Handlers;

use App\BotKernel\MessengerContexts\IMessengerContext;
use App\Telegram\Repositories\UserRepository;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Telegram\Bot\Api;
use Telegram\Bot\Objects\PhotoSize;

class SetPhoto implements IMessageHandler
{
    /**
     * @var Api
     */
    private $telegram;

    /**
     * @var Filesystem
     */
    private $storage;

    /**
     * @var UserRepository
     */
    private $userRepo;

    public function __construct(Api $telegram, Filesystem $storage, UserRepository $userRepo)
    {
        $this->telegram = $telegram;
        $this->storage = $storage;
        $this->userRepo = $userRepo;
    }

    public function handle(IMessengerContext $messenger)
    {
        $photo = $messenger->get('photo');

        $file = $this->telegram->getFile([
            'file_id' => $photo[2]['file_id']
        ]);

        $filePath = $file->getFilePath();

        $fileUrl = 'https://api.telegram.org/file/bot'. $this->telegram->getAccessToken() .'/' . $filePath;

        $path = 'telegram/users/'. Str::random(16) .'.'. pathinfo($filePath, PATHINFO_EXTENSION);

        $this->storage->put($path, file_get_contents($fileUrl));

        $this->userRepo->update($messenger->getUser(), [
            'image' => $path
        ]);

        $messenger->set('reply_photo', $path);

        $messenger->getUserManager()->setContext('feedback');

        return 'Спасибо, теперь вы можете оставить отзыв. Просто отправьте сообщение, мы будем рады положительному фидбеку 😉';
    }
}
