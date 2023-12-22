<?php

namespace App\Helpers;

class BotActionHelper
{
    public const MENU = 1;
    public const LANGUAGE = 2;
    public const CAPTCHA = 3;
    public const INTRO_STEP_1 = 4;
    public const INTRO_STEP_2 = 5;
    public const INTRO_STEP_3 = 6;
    public const INTRO_STEP_4 = 7;
    public const SUBSCRIBE_CAPTCHA = 8;
    public const TOKEN = 9;
    public const TOKEN_SITE = 10;
    public const TOKEN_PROMOCODE_SUBSCRIBE = 11;
    public const TOKEN_PROMOCODE = 12;
    public const REFERRAL = 13;
    public const TASKS_MENU = 14;
    public const TASKS_TOKEN = 15;
    public const GAME = 16;
    public const GAME_TOKEN = 17;
    public const OTHER = 18;

    private static array $types = [
        //self::LANGUAGE => 'language',
        self::CAPTCHA => 'captcha',
        self::INTRO_STEP_1 => 'intro_1',
        self::INTRO_STEP_2 => 'intro_2',
        self::INTRO_STEP_3 => 'intro_3',
        //self::INTRO_STEP_4 => 'intro_4',
        //self::SUBSCRIBE_CAPTCHA => 'subscribe_captcha',
        self::MENU => 'menu',
        self::TOKEN => 'token',
        self::TOKEN_SITE => 'token_site',
        self::TOKEN_PROMOCODE_SUBSCRIBE => 'token_channel_subscribe',
        self::TOKEN_PROMOCODE => 'token_promocode',
        self::REFERRAL => 'referral',
        self::TASKS_MENU => 'tasks',
        self::TASKS_TOKEN => 'tasks_token',
        self::GAME => 'game',
        self::GAME_TOKEN => 'game_token',
        //self::OTHER => 'other',
    ];

    public static function getMacros(): array
    {
        $arr = [];
        foreach (self::$types as $key => $type) {
            if ($key != self::OTHER) {
                $arr[] = 'notification.' . $type . '_step_1';
                $arr[] = 'notification.' . $type . '_step_2';
            }
        }
        $arr[] = 'notification.menu_button';
        return $arr;
    }

    public static function getMacro($type, $step): string
    {
        return 'notification.' . self::$types[$type] . '_step_' . $step;
    }
}
