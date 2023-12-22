<?php

namespace App\Services\Telegram\Screens;

use App\Services\Telegram\Traits\KeyboardsTrait;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class StartScreen extends AbstractScreen
{

    use KeyboardsTrait;

    public static array $macro = [
        'system.back_to_menu',
        'start.text',
        'about.text',
        'social.text',
        //'leaderboard.text',
        'start.button_token',
        'start.button_referral',
        'start.button_tasks',
        'start.button_game',
        'start.button_promocode',
        'start.button_about',
        'start.button_social',
//        'start.button_wallet',
//        'start.button_language',
//        'start.button_leaderboard',
    ];
    /**
     * @throws \Exception
     */
    public function index()
    {

        $keyboard = new InlineKeyboardMarkup([
            [
                [
                    'text' => 'test',
                    'callback_data' => $this->MakeCallbackData(
                        CommandNotFoundScreen::class
                    ),
                ]
            ],
        ]);

        $txt = $this->macro('start.text');

        $this->api->sendMessage($txt, $keyboard);

        return $this->next(CommandNotFoundScreen::class, 'handle');
    }
}
