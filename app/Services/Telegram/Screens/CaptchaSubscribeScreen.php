<?php


namespace App\Services\Telegram\Screens;


use App\Helpers\BotActionHelper;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;

class CaptchaSubscribeScreen extends AbstractScreen
{

    public static array $macro = [
        'captcha_subscribe.text',
        'captcha_subscribe.channel_name',
        'captcha_subscribe.channel_url',
        'captcha_subscribe.i_subscribed_button',
        'captcha_subscribe.error_subscribe',
//        'captcha_subscribe.success_subscribe',
        'captcha_subscribe.step_1_text',
        'captcha_subscribe.step_1_button',
        'captcha_subscribe.step_2_text',
        'captcha_subscribe.step_2_button',
        'captcha_subscribe.step_3_text',
        'captcha_subscribe.step_3_button',
        //'captcha_subscribe.step_4_text',
        //'captcha_subscribe.step_4_button',
    ];

    public function index()
    {
        return $this->step_1();
    }

    public function step_1()
    {
        $this->setAction(BotActionHelper::INTRO_STEP_1);
        $keyboard = new InlineKeyboardMarkup([
            [
                [
                    'text' => $this->macro('captcha_subscribe.step_1_button'),
                    'callback_data' => $this->MakeCallbackData(
                        self::class,
                        'step_2'
                    ),
                ],
            ],
        ]);
        $txt = $this->macro('captcha_subscribe.step_1_text');
        $this->api->sendMessage($txt, $keyboard);
        return $this->next(CommandNotFoundScreen::class, 'handle');
    }

    public function step_2()
    {
        $this->setAction(BotActionHelper::INTRO_STEP_2);
        $keyboard = new InlineKeyboardMarkup([
            [
                [
                    'text' => $this->macro('captcha_subscribe.step_2_button'),
                    'callback_data' => $this->MakeCallbackData(
                        self::class,
                        'step_3'
                    ),
                ],
            ],
        ]);
        $txt = $this->macro('captcha_subscribe.step_2_text');
        $this->api->sendMessage($txt, $keyboard);
        return $this->next(CommandNotFoundScreen::class, 'handle');
    }

    public function step_3()
    {
        $this->setAction(BotActionHelper::INTRO_STEP_3);
        $keyboard = new InlineKeyboardMarkup([
            [
                [
                    'text' => $this->macro('captcha_subscribe.step_3_button'),
                    'callback_data' => $this->MakeCallbackData(
                        self::class,
                        'subscribe'
                    ),
                ],
            ],
        ]);
        $txt = $this->macro('captcha_subscribe.step_3_text');
        $this->api->sendMessage($txt, $keyboard);
        return $this->next(CommandNotFoundScreen::class, 'handle');
    }

    public function step_4()
    {
        $this->setAction(BotActionHelper::INTRO_STEP_4);
        $keyboard = new InlineKeyboardMarkup([
            [
                [
                    'text' => $this->macro('captcha_subscribe.step_4_button'),
                    'callback_data' => $this->MakeCallbackData(
                        self::class,
                        'subscribe'
                    ),
                ],
            ],
        ]);
        $txt = $this->macro('captcha_subscribe.step_4_text');
        $this->api->sendMessage($txt, $keyboard);
        return $this->next(CommandNotFoundScreen::class, 'handle');
    }

    public function subscribe()
    {
        $this->user->captcha_subscribe = 1;
        $this->user->save();
        return $this->redirect(StartScreen::class);

        $this->setAction(BotActionHelper::SUBSCRIBE_CAPTCHA);
        $keyboard = new InlineKeyboardMarkup([
            [
                [
                    'text' => $this->macro('captcha_subscribe.channel_name'),
                    'url' => $this->macro('captcha_subscribe.channel_url'),
                ],
            ],
            [
                [
                    'text' => $this->macro('captcha_subscribe.i_subscribed_button'),
                    'callback_data' => $this->MakeCallbackData(
                        self::class,
                        'check'
                    ),
                ],
            ],
        ]);
        $txt = $this->macro('captcha_subscribe.text');
        $this->api->sendMessage($txt, $keyboard);
        return $this->next(CommandNotFoundScreen::class, 'handle');
    }

    public function check()
    {
        $b = false;
        try {
            $res = $this->api->getFullChatMember(env('TG_CHANNEL_ID'), $this->user->tid);
            if (!empty($res)
                && ((is_null($res->isMember()) && !in_array($res->getStatus(), ['kicked', 'left'])) || ($res->isMember()))
            ) {
                $b = true;
            }

        } catch (\Exception $e) {
            $b = false;
        }

        if (!$b) {
            $txt = $this->macro('captcha_subscribe.error_subscribe');
            $this->api->sendMessage($txt);
            return $this->next(CommandNotFoundScreen::class, 'handle');
        } else {
//            $txt = $this->macro('captcha_subscribe.success_subscribe');
//            $this->api->sendMessage($txt);
            $this->user->captcha_subscribe = 1;
            $this->user->save();
            return $this->redirect(StartScreen::class);
        }
    }
}
