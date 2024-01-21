<?php

namespace App\Services\Telegram\Api;

use App\Models\ReferralLink;
use App\Models\TgGroup;
use App\Models\TgHashRoute;
use App\Models\TgUser;
use App\Services\Telegram\Screens\CommandNotFoundScreen;
use App\Services\Telegram\Screens\SendScreen;
use App\Services\Telegram\Traits\RoutesTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class ServiceScreen
{

    use RoutesTrait;

    private UpdateApi $payload;
    private ?TgUser $user = null;
    private Api $api;

    private function upsertTgUser()
    {
        $from = $this->payload->getFrom();
        /**
         * @var TgUser $user
         */
        $user = TgUser::findByTid($from->getId());
        if (empty($user)) {
            $user = new TgUser();
            $user->tid = $from->getId();
            $user->first_name = $from->getFirstName() ?? null;
            $user->last_name = $from->getLastName() ?? null;
            $user->username = $from->getUsername() ?? null;
            $user->referral_hash = TgUser::generateHash('referral_hash');
            $user->referral_id = 0;
            //$user->season_id = Season::getIdActiveSeason();
            $user->referral_at = null;
            $user->unlock_at = null;
            //$user->game_hash = TgUser::generateHash('game_hash');
            $user->language_code = $from->getLanguageCode() ?? null;
            //$user->game_attempts = 10;
            $user->save();

        } else {
            $tmp = false;
            if ($user->first_name != ($from->getFirstName() ?? null)) {
                $user->first_name = $from->getFirstName() ?? null;
                $tmp = true;
            }
            if ($user->last_name != ($from->getLastName() ?? null)) {
                $user->last_name = $from->getLastName() ?? null;
                $tmp = true;
            }
            if ($user->username != ($from->getUsername() ?? null)) {
                $user->username = $from->getUsername() ?? null;
                $tmp = true;
            }
            if ($user->banned == 1) {
                $user->banned = 0;
                $tmp = true;
            }
            if ($user->language_code != ($from->getLanguageCode() ?? null)) {
                $user->language_code = $from->getLanguageCode() ?? null;
                $tmp = true;
            }

            if ($tmp) {
                $user->save();
            }
        }
        $this->user = $user;
    }

    private function upsertTgGroupMyMember(): bool
    {
        $myChatMember = $this->payload->getMyChatMember();
        if ($myChatMember) {
            $this->upsertTgGroup($myChatMember);
            return true;
        }
        return false;
    }

    private function upsertTgGroup(MyChatMember $myChatMember = null): void
    {
        $chat = $myChatMember?->getChat() ?? $this->payload->getChat();

        if ($chat->getType() == 'private' && empty($myChatMember)) {
            return;
        }

        $group = TgGroup::query()
            ->where('tid', '=', $chat->getId())
            ->first();

        $myChatMember = $this->payload->getMyChatMember();

        if (empty($group)) {
            $group = new TgGroup();
            $group->tid = $chat->getId();
            $group->type = $chat->getType() ?? '';
            $group->name = $chat->getTitle();
            $group->username = $chat->getUsername();

            if ($myChatMember?->getNewChatMember()) {
                $group->status = $myChatMember?->getNewChatMember()->getStatus() ?? 'member';
            }
            $group->save();
        } else {
            $updateGroup = false;
            if ($group->name != ($chat->getTitle() ?? '')) {
                $updateGroup = true;
                $group->name = $chat->getTitle() ?? '';
            }
            if ($group->type != ($chat->getType() ?? null)) {
                $updateGroup = true;
                $group->type = $chat->getType() ?? null;
            }
            if ($myChatMember?->getNewChatMember() && ($group->status != $myChatMember?->getNewChatMember()->getStatus() ?? 'member')) {
                $updateGroup = true;
                $group->status = $myChatMember?->getNewChatMember()->getStatus() ?? 'member';
            }
            if ($updateGroup) {
                $group->save();
            }
        }
    }

    public function run()
    {
        // Получение инфы о добавлении бота в группу
        if ($this->upsertTgGroupMyMember()) {
            return null;
        }

        if (!$this->payload->isApprovedData()) {
            return null;
        }

        $this->upsertTgUser();

        if ($this->user->unlock_at != null) {
            if ($this->user->unlock_at > Carbon::now()) {
                return null;
            } else {
                RateLimiter::clear('message-limiter:' . $this->user->id);
                $this->user->unlock_at = null;
                $this->user->save();
            }
        }

        if (RateLimiter::tooManyAttempts('message-limiter:' . $this->user->id, $perMinute = 60)) {
            $this->user->unlock_at = Carbon::now()->addMinutes(15);
            $this->user->save();
            return null;
        }


        RateLimiter::hit('message-limiter:' . $this->user->id);

        $this->createApi();

        $screen = null;
        $method = null;
        $data = null;

        $routes = $this->getRoutes();

        /* проверяем прямые роуты если пришел текст */
        if ($this->payload->getMessage() != null) {
            $message = $this->payload->getMessage()->getText();
            foreach ($routes as $route) {
                if (Str::startsWith($message ?? '', $route['keys'])) {
                    $screen = $route['class'];
                    $method = $route['method'] ?? 'index';
                    break;
                }
            }
        }

        // если пришел callBack по кнопке
        if ($this->payload->getCallbackQuery() != null) {
            $callback_query_data = $this->payload->getCallbackQuery()->getData();
            $hash_route = TgHashRoute::query()
                ->where('hash', $callback_query_data)
                ->first();
            if (!empty($hash_route)) {
                $data_route = json_decode($hash_route->data, true);
                $screen = $data_route['class'];
                $method = $data_route['method'];
                $data = $data_route['data'];
                $this->api->api->answerCallbackQuery($this->payload->getCallbackQuery()->getId());
            }
        }

        if ($this->user->is_banned == 1) {
            return null;
        }

        $key = 'screen-state-cache-user-' . $this->user->id;

        if (empty($screen)) {
            if (Cache::has($key)) {
                $cache = Cache::get($key);
                if (is_array($cache)) {
                    $screen = $cache['class'];
                    $method = $cache['method'] ?? 'index';
                    $data = $cache['data'] ?? null;
                } else {
                    $screen = CommandNotFoundScreen::class;
                    $method = 'index';
                }
            } else {
                $screen = CommandNotFoundScreen::class;
                $method = 'index';
            }
        }

        // referral
//        if ($this->payload->getMessage() != null) {
//            $text = $this->payload->getMessage()->getText() ?? '';
//            $arr = explode(' ', $text);
//            if (!empty($arr[1])) {
//                $code = $arr[1];
//
//                $ref_l = ReferralLink::query()
//                    ->where('hash', $code)
//                    ->first();
//                if (!empty($ref_l) && empty($user->referral_link_id)) {
//                    $this->user->referral_link_id = $ref_l->id;
//                    $this->user->referral_at = Carbon::now();
//                    $this->user->save();
//                }
//
//                /** @var TgUser $ref_user */
//                $ref_user = TgUser::query()
//                    ->where('referral_hash', $code)
//                    ->first();
//
//                if (!empty($ref_user) && ($ref_user->id != $this->user->id)
//                    && ($ref_user->referral_id != $this->user->id) && empty($this->user->referral_id)) {
//                    $this->user->referral_id = $ref_user->id;
//                    $this->user->referral_at = Carbon::now();
//                    $this->user->save();
//                }
//
//                if (Str::startsWith($code, 'q_')) {
//                    $code = Str::substr($code,2);
//                    $api = new IntegrationService();
//                    $api->setTgId($this->user, $code);
//
//                    $screen_ = new SendScreen();
//                    $screen_->setUser($this->user);
//                    $screen_->setPayload($this->payload);
//                    $screen_->setService($this->api);
//                    $screen_->sendSyncUserWithSite();
//
//                }
//            }
//        }

        $result = null;
        if (class_exists($screen) && method_exists($screen, $method)) {
            $result = $this->exec_screen($screen, $method, $data);
        } else {
            Cache::put($key, null);
            $this->api->sendMessage('Command not found. Enter /start');
        }

        if ($result !== null) {
            Cache::put($key, $result ?? null);
        }

    }

    public function exec_screen($screen, $method, $data = null)
    {
//        if ($this->user->selected_language == 0) {
//            if ($screen != LangScreen::class) {
//                $screen = LangScreen::class;
//                $method = 'index';
//            }
//        } elseif ($this->user->captcha_passed == 0) {
//            if ($screen != CaptchaScreen::class) {
//                $screen = CaptchaScreen::class;
//                $method = 'index';
//            }
//        } elseif ($this->user->captcha_subscribe == 0) {
//            if ($screen != CaptchaSubscribeScreen::class) {
//                $screen = CaptchaSubscribeScreen::class;
//                $method = 'index';
//            }
//        }

        $screen = new $screen();
        $screen->setUser($this->user);
        $screen->setPayload($this->payload);
        $screen->setService($this->api);

        $result = empty($data) ? $screen->$method() : $screen->$method($data);

        if (!empty($result) && is_array($result) && !empty($result['type'])) {
            if ($result['type'] == 'redirect') {
                $screen = $result['class'];
                $method = $result['method'];
                $data = $result['data'] ?? null;
                $result = null;
                return $this->exec_screen($screen, $method, $data);
            }
        }

        return $result;
    }

    public function createApi()
    {
        $this->api = new Api();
        if ($this->user) {
            $this->api->setUserModel($this->user);
        }
    }

    public function setPlayload(UpdateApi $payload)
    {
        $this->payload = $payload;
    }

    public function getChatMember($chat_id, $user_id)
    {
        return $this->api->getChatMember($chat_id, $user_id);
    }
}
