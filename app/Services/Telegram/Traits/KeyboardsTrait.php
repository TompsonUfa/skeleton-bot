<?php

namespace App\Services\Telegram\Traits;


use TelegramBot\Api\Types\ReplyKeyboardRemove;

trait KeyboardsTrait
{

    public function ReplyKeyboardRemove()
    {
        return new ReplyKeyboardRemove();
    }

    public function commands()
    {
        return [
            ['command' => '/menu', 'description' => 'Главное меню',],
        ];
    }


}
