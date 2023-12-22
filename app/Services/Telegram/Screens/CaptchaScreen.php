<?php


namespace App\Services\Telegram\Screens;


use App\Helpers\BotActionHelper;

class CaptchaScreen extends AbstractScreen
{

    public static array $macro = [
        'captcha.attempt_1',
        'captcha.attempt_2',
        'captcha.attempt_3',
        'captcha.block_user',
        'captcha.success',
    ];

    public function index()
    {
        $this->setAction(BotActionHelper::CAPTCHA);
        if ($this->user->captcha_attempts == 0) {
            return $this->attempt_1();
        }

        if ($this->user->captcha_attempts == 1) {
            return $this->attempt_2();
        }

        if ($this->user->captcha_attempts == 2) {
            return $this->attempt_3();
        }

        return $this->attempt_4();
    }

    public function attempt_1()
    {
        $a = rand(3, 15);
        $b = rand(20, 90);
        $this->user->captcha_value = $a + $b;
        $this->user->save();
        $txt = $this->macro('captcha.attempt_1');
        $this->api->sendMessage($txt);
        $this->api->sendMessage($a . ' + ' . $b . ' = ?');
        return $this->next(self::class, 'handle');
    }

    public function attempt_2()
    {
        $a = rand(3, 15);
        $b = rand(20, 90);
        $this->user->captcha_value = $a + $b;
        $this->user->save();
        $txt = $this->macro('captcha.attempt_2');
        $this->api->sendMessage($txt);
        $this->api->sendMessage($a . ' + ' . $b . ' = ?');
        return $this->next(self::class, 'handle');
    }

    public function attempt_3()
    {
        $a = rand(3, 15);
        $b = rand(20, 90);
        $this->user->captcha_value = $a + $b;
        $this->user->save();
        $txt = $this->macro('captcha.attempt_3');
        $this->api->sendMessage($txt);
        $this->api->sendMessage($a . ' + ' . $b . ' = ?');
        return $this->next(self::class, 'handle');
    }

    public function attempt_4()
    {
        $this->user->is_banned = 1;
        $this->user->save();
        $txt = $this->macro('captcha.block_user');
        $this->api->sendMessage($txt);
        return $this->next(CommandNotFoundScreen::class, 'handle');
    }

    public function handle()
    {
        $text = '';
        if ($this->payload->getMessage() != null) {
            $text = $this->payload->getMessage()->getText() ?? '';
        }

        if ($text == $this->user->captcha_value) {
            $this->user->captcha_passed = 1;
            $this->user->save();
            $txt = $this->macro('captcha.success');

            $this->api->sendMessage($txt);
            return $this->redirect(StartScreen::class);
        }

        $this->user->captcha_attempts += 1;
        $this->user->save();
        return $this->index();
    }


}
