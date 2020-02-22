<?php

namespace App\Telegram\Models;

use App\BotKernel\User\IUser;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements IUser
{
    protected $table = 'telegram_users';

    public $incrementing = false;

    protected $fillable = ['first_name', 'last_name', 'language_code', 'is_bot'];

    public function getId()
    {
        return $this->id;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function getName()
    {
        return $this->username;
    }

    public function getPayload()
    {
        return json_decode($this->payload, true);
    }
}
