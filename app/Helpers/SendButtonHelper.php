<?php

namespace App\Helpers;

class SendButtonHelper
{
    public const BUTTON_TYPE_URL = 'url';
    public const BUTTON_TYPE_WEB_APP = 'web_app';
    public const BUTTON_TYPE_WEB_APP_CAPTCHA = 'web_app_captcha';
    public const BUTTON_TYPE_SCREEN = 'screen';

    private static array $types = [
        self::BUTTON_TYPE_URL => 'Standart link',
        self::BUTTON_TYPE_WEB_APP => 'Web app',
        self::BUTTON_TYPE_WEB_APP_CAPTCHA => 'Web app captcha',
//        self::BUTTON_TYPE_SCREEN => 'Bot screen',
    ];

    public const BUTTON_DATA_TYPE_LINK = 'link';

    private static array $screenData = [
//        'menu' => [
//            'caption' => 'Menu',
//            'class' => StartScreen::class,
//            'method' => 'index'
//        ],
    ];

    public static function getTypes() : array
    {
        return self::$types;
    }

    public static function getScreenData($key) : array|null
    {
        return self::$screenData[$key] ?? null;
    }

    public static function getScreens() : array
    {
        return self::$screenData;
    }
}
