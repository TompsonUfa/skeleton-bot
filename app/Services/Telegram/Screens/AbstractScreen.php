<?php

namespace App\Services\Telegram\Screens;

use App\Models\Content;
use App\Models\Referral;
use App\Models\TgHashRoute;
use App\Models\TgUser;
use App\Services\GameStatService;
use App\Services\ReferralTopService;
use App\Services\Season;
use App\Services\Telegram\Api\Api;
use App\Services\Telegram\Api\UpdateApi;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

abstract class AbstractScreen
{

    /**
     * @var Api $api
     */
    public Api $api;


    /**
     * @var TgUser $user
     */
    public TgUser $user;


    /**
     * Данные которые пришли с web-hook
     * @var array
     */
    protected UpdateApi $payload;

    public function setPayload(UpdateApi $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @param Api $api
     */
    public function setService(Api $bot)
    {
        $this->api = $bot;
    }


    /**
     * @param TgUser $user
     */
    public function setUser(TgUser $user)
    {
        $this->user = $user;
    }

    public function MakeCallbackData($class, $method = 'index', $data = [])
    {
        $data = json_encode(
            [
                'class' => $class,
                'method' => $method,
                'data' => $data,
            ]
        );
        $hash = TgHashRoute::query()
            ->where('data', $data)
            ->first();
        if (empty($hash)) {
            $h = md5($data);
            $hash = new TgHashRoute();
            $hash->data = $data;
            $hash->hash = $h;
            $hash->save();
        }
        return $hash->hash;
    }

    public function next($class, $method = 'index', $data = null)
    {
        return [
            'type' => 'next',
            'class' => $class,
            'method' => $method,
            'data' => $data,
        ];
    }

    public function redirect($class, $method = 'index', $data = null)
    {
        return [
            'type' => 'redirect',
            'class' => $class,
            'method' => $method,
            'data' => $data,
        ];
    }

    /**
     * @param string $key
     * @param $value
     */
    public function setCache(string $key, $value, $hours = 24)
    {
        $cacheKey = 'screen-store-' . $this->user->id . '-' . $key;
        Cache::put($cacheKey, $value, now()->addHours($hours));
    }

    /**
     * @param string|null $key
     * @param string|null $default
     * @return array|mixed|false
     */
    public function getCache($key = null, $default = null)
    {
        if (empty($key)) {
            return null;
        }
        $cacheKey = 'screen-store-' . $this->user->id . '-' . $key;

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        return $default;
    }

    public function macro($macro, $data = [])
    {
        /**
         * @var Content $model
         */
        $model = Content::query()
            ->where('macro', $macro)
            ->where('lang', $this->user->selected_language ?? 'en')
            ->first();
        if (empty($model)) {
            $text = $macro;
        } else {
            $text = $model->data;
        }
        $season_id = Season::getIdActiveSeason();
        $referralCount = Referral::whereUserId($this->user->id)->whereSeasonId($season_id)->first()?->referral_count ?? 0;

        if (Str::contains($text, '__name__')) {
            $text = Str::replace('__name__', $this->user->first_name, $text);
        }
        if (Str::contains($text, '__lastname__')) {
            $text = Str::replace('__lastname__', $this->user->last_name ?? '', $text);
        }
        if (Str::contains($text, '__username__')) {
            $username = !empty($this->user->username) ? '@' . $this->user->username : '';
            $text = Str::replace('__username__', $username, $text);
        }
        if (Str::contains($text, '__referral_link__')) {
            $url = 'https://t.me/' . env('TELEGRAM_USERNAME') . '?start=' . $this->user->referral_hash;
            $text = Str::replace('__referral_link__', $url, $text);
        }
        if (Str::contains($text, '__referral_count_only_captcha__')) {
            $count = TgUser::query()
                ->where('referral_id', $this->user->id)
                ->where('captcha_passed', 1)
//                ->where('referral_enable', 0)
//                ->where('wallet', '')
                ->count();
            $text = Str::replace('__referral_count_only_captcha__', $count, $text);
        }
        if (Str::contains($text, '__referral_count_without_wallet__')) {
            $referral_count_without_wallet = TgUser::query()
                ->where('referral_id', $this->user->id)
                ->where('referral_enable', 1)
                ->where('wallet', '')
                ->count();
            $text = Str::replace('__referral_count_without_wallet__', $referral_count_without_wallet, $text);
        }
        if (Str::contains($text, '__referral_count__')) {
            $text = Str::replace('__referral_count__', $referralCount, $text);
        }
        if (Str::contains($text, '__user_points__')) {
            $points = $this->user->userPoints()->sum('point');
            $text = Str::replace('__user_points__', $points, $text);
        }
        if (Str::contains($text, '__user_points_in_season__')) {
            $points = $this->user->userPoints()->where('season_id', $season_id)->sum('point');
            $text = Str::replace('__user_points_in_season__', $points, $text);
        }
        if (preg_match('/__referral_top_[0-9]+__/', $text)) {
            $top = app(ReferralTopService::class)->getTop($season_id);
            for ($i = 0; $i < 25; $i++) {
                $first_name = '';
                $ref_count = '';
                if (!empty($top[$i])) {
                    $first_name = trim($top[$i]->user->first_name);
                    $ref_count = $top[$i]->referral_count;
                }

                $text = Str::replace("__referral_top_" . ($i + 1) . "__", $first_name, $text);
                $text = Str::replace("__referral_top_" . ($i + 1) . "_ref_count__", $ref_count, $text);
            }
        }
        if (Str::contains($text, '__referral_position__')) {
            if ($referralCount == 0) {
                $pos = 0;
            } else {
                $pos = app(ReferralTopService::class)->getPosition($season_id, $referralCount);
                $pos++;
            }
            $text = Str::replace('__referral_position__', $pos, $text);
        }
        if (Str::contains($text, '__referral_need__')) {
            $need = app(ReferralTopService::class)->getUserNeedReferrals($season_id, $referralCount);
            $text = Str::replace('__referral_need__', $need, $text);
        }
        if (preg_match('/__game_top_[0-9]+__/', $text)) {
            $top = app(GameStatService::class)->getTop($season_id);
            for ($i = 0; $i < 25; $i++) {
                $first_name = '';
                $score = '';
                if (!empty($top[$i])) {
                    $first_name = trim($top[$i]->user->first_name);
                    $score = $top[$i]->score_sum;
                }

                $text = Str::replace("__game_top_" . ($i + 1) . "__", $first_name, $text);
                $text = Str::replace("__game_top_" . ($i + 1) . "_score__", $score, $text);
            }
        }
        if (Str::contains($text, '__game_position__')) {
            if (!$this->user->has_token) {
                $pos = 0;
            }
            elseif (app(GameStatService::class)->getUserScores($this->user->id, $season_id) == 0) {
                $pos = 0;
            } else {
                $pos = app(GameStatService::class)->getUserPosition($this->user->id, $season_id);
                $pos++;
            }
            $text = Str::replace('__game_position__', $pos, $text);
        }
        if (Str::contains($text, '__game_need__')) {
            $need = app(GameStatService::class)->getUserNeedScores($this->user->id, $season_id);
            $text = Str::replace('__game_need__', $need, $text);
        }
        if (Str::contains($text, '__game_scores__')) {
            $score = app(GameStatService::class)->getUserScores($this->user->id, $season_id);
            $text = Str::replace('__game_scores__', $score ?? 0, $text);
        }
//        if (Str::contains($text, '__wallet__')) {
//            $text = Str::replace('__wallet__', $this->user->wallet, $text);
//        }

        foreach ($data as $k => $v) {
            $text = Str::replace($k, $v ?? '', $text ?? '');
        }
        return $text;
    }

    public function saveSendMessageResult($result)
    {
        $this->setCache('message_' . $result->getMessageId(), $result->getText());
    }

    public function clearSendMessageResult()
    {
        if ($this->payload->getCallbackQuery() == null) {
            return null;
        }
        $message_id = $this->payload->getCallbackQuery()->getMessage()->getMessageId();
        $message = $this->getCache('message_' . $message_id);
        if (empty($message)) {
            return null;
        }
        try {
            $this->api->editMessageText($message_id, $message);
        } catch (Exception $e) {
        }
        $this->setCache('message_' . $message_id, null, 0);
    }

    public function deleteMessage($message_id)
    {
        $this->api->api->deleteMessage($this->user->tid, $message_id);
    }

    public function referralCounting(): void
    {
        if ($this->user->referral_id != 0 && $this->user->referral_counted == 0) {
            $this->user->referral_counted = 1;
            $this->user->save();

            /* @var Referral $ref */
            $ref = Referral::query()->firstOrCreate([
                'user_id' => $this->user->referral_id,
                'season_id' => Season::getIdActiveSeason()
            ]);;
            $ref->referral_count += 1;
            $ref->save();

            $api = new Api();
            $screen = new SendScreen();
            $screen->setService($api);

            /* @var TgUser $refUser */
            $refUser = TgUser::query()->find($this->user->referral_id);
            if ($refUser) {
                $refUser->game_attempts++;
                $refUser->save();

                $api->setUserModel($refUser);
                $screen->setUser($refUser);
                try {
                    $screen->sendNotifNewReferral($this->user);
                } catch (Exception) {
                }
            }
        }
    }

    public function setAction($action): void
    {
        if ($action != $this->user->last_action) {
            $this->user->last_action = $action;
            $this->user->last_action_time = time();
            $this->user->action_notif_step = 0;
            $this->user->save();
        }
    }
}
