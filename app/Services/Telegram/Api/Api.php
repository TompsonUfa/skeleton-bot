<?php

namespace App\Services\Telegram\Api;

use App\Models\TgUser;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use JetBrains\PhpStorm\ArrayShape;
use TelegramBot\Api\Types\Inline\QueryResult\AbstractInlineQueryResult;
use TelegramBot\Api\Types\InputMedia\ArrayOfInputMedia;
use TelegramBot\Api\Types\InputMedia\InputMediaPhoto;
use TelegramBot\Api\Types\Message;

class Api
{
    public $token = null;
    public $secret = null;
    public $api = null;

    public $tid;
    public TgUser $user;
    public $group;


    public function __construct()
    {
        $this->token = env('TELEGRAM_TOKEN', null);
        if (empty($this->token)) {
            throw new \Exception('Empty bot token');
        }
        $this->secret = env('TELEGRAM_SECRET', null);
        if (empty($this->token)) {
            $this->secret = $this->secret . '/';
        }
        $this->api = new BotApi($this->token);
    }

    public function deleteMyCommands(
        #[ArrayShape([
            'type' => 'string',
            'chat_id?' => 'string',
            'user_id?' => 'string'
        ])] array $scope = null,
        string $language_code = null
    )
    {
        return $this->api->call(
            method: 'deleteMyCommands',
            data: [
            'scope' => json_encode($scope),
            'language_code' => $language_code,
        ]);
    }


    public function setWebhook($dropPendingUpdates = false)
    {
        $url = env('APP_URL') . '/telegram/' . $this->secret;
        return $this->api->setWebhook($url, dropPendingUpdates: $dropPendingUpdates);
    }

    public function getWebhookInfo()
    {
        return $this->api->getWebhookInfo();
    }

    public function setUserModel(TgUser $user)
    {
        $this->user = $user;
        $this->tid = $user->tid;
    }

    public function sendAudio($url, $caption = null)
    {
        try {
            return $this->api->sendAudio($this->tid, $url, $caption);
        } catch (\Exception $e) {
//            Log::info(__CLASS__ . ' ' . __METHOD__);
//            Log::error($e->getMessage());
        }
    }

    public function sendDocument($url, $caption = null)
    {
        try {
            return $this->api->sendDocument($this->tid, $url, $caption, null, null,
                false, 'html');
        } catch (\Exception $e) {
//            Log::info(__CLASS__ . ' ' . __METHOD__);
//            Log::error($e->getMessage());
        }
    }

    public function sendVideoNote($fileData): ?Types\Message
    {
        try {
            $res = $this->api->sendVideoNote(
                chatId: $this->tid,
                videoNote: $fileData
            );
            $cacheKey = 'tg.messages.' . $this->user->id;
            $cachedArray = Cache::get($cacheKey, []);
            $cachedArray[] = $res->getMessageId();
            Cache::put($cacheKey, $cachedArray);
            return $res;
        } catch (\Exception $e) {
        }
    }

    public function sendVideo($video, $text = '', $keyboard = null)
    {
        try {
            $res = $this->api->sendVideo(
                chatId: $this->user->tid,
                video: $video,
                caption: $text,
                replyMarkup: $keyboard,
                parseMode: 'html',
            );
            $cacheKey = 'tg.messages.' . $this->user->id;
            $cachedArray = Cache::get($cacheKey, []);
            $cachedArray[] = $res->getMessageId();
            Cache::put($cacheKey, $cachedArray);
            return $res;
        } catch (\Exception $e) {
//            \Log::info(__CLASS__ . ' ' . __METHOD__);
//            \Log::error($e->getMessage());
        }
    }

    public function sendMessage($text, $keyboard = null, $disablePreview = false)
    {
        if (!empty($text)) {
            try {
                $text = str_replace('</p>', '</p>' . PHP_EOL, $text);
                $text = strip_tags($text, '<b><strong><i><em><u><ins><s><strike><del><a><code><pre>');
                $res = $this->api->sendMessage($this->tid, $text, 'html',
                    $disablePreview, null, $keyboard);
                $cacheKey = 'tg.messages.' . $this->user->id;
                $cachedArray = Cache::get($cacheKey, []);
                $cachedArray[] = $res->getMessageId();
                Cache::put($cacheKey, $cachedArray);
                return $res;
            } catch (\Exception $e) {
                $this->user->banned = 1;
                $this->user->save();
                //Log::info(__CLASS__ . ' ' . __METHOD__);
                //Log::error($e->getMessage());
            }
        }
    }

    public function editMessageText($message_id, $text, $keyboard = null)
    {
        try {
            $text = str_replace('</p>', '</p>' . PHP_EOL, $text);
            $text = strip_tags($text, '<b><strong><i><em><u><ins><s><strike><del><a><code><pre>');
            return $this->api->editMessageText($this->tid, $message_id, $text, 'html', false, $keyboard);
        } catch (\Exception $e) {
//            Log::info(__CLASS__ . ' ' . __METHOD__);
//            Log::error($e->getMessage());
        }
    }

    public function editMessagePhoto($message_id, $photo, $text)
    {
        try {
            $photo = new InputMediaPhoto($photo, $text);
            return $this->api->editMessageMedia($this->tid, $message_id, $photo);
        } catch (\Exception $e) {
//            Log::info(__CLASS__ . ' ' . __METHOD__);
//            Log::error($e->getMessage());
        }
    }

    public function sendPhoto($photo, $caption = null, $keyboard = null)
    {
        try {
            return $this->api->sendPhoto($this->tid, $photo, $caption, null, $keyboard, null, 'html');
        } catch (\Exception $e) {
//            Log::info(__CLASS__ . ' ' . __METHOD__);
//            Log::error($e->getMessage());
        }
    }

    public function sendPhotos($photos)
    {
        $arr = new ArrayOfInputMedia();
        foreach ($photos as $item) {
            $p = new InputMediaPhoto($item);
            $arr->addItem($p);
        }

        try {
            return $this->api->sendMediaGroup($this->tid, $arr);
        } catch (\Exception $e) {
//            Log::info(__CLASS__ . ' ' . __METHOD__);
//            Log::error($e->getMessage());
        }
    }

    public function answerCallbackQuery($callbackQueryId)
    {
        return $this->api->answerCallbackQuery($callbackQueryId);
    }

    public function downloadFile($fileId)
    {
        return $this->api->downloadFile($fileId);
    }

    public function sendPoll($question, $options)
    {
        return $this->api->sendPoll($this->tid,
            $question,
            $options);
    }

    public function deleteMessage($messageId)
    {
        try {
            return $this->api->deleteMessage($this->tid, $messageId);
        } catch (\TelegramBot\Api\Exception $e) {

        }
        return null;
    }

    public function setMyCommands(
        array $commands,
        #[ArrayShape([
            'type' => 'string',
            'chat_id?' => 'string',
            'user_id?' => 'string'
        ])] array $scope = null,
        string $language_code = null
    )
    {
        return $this->api->call(
            'setMyCommands',
            [
                'commands' => json_encode($commands),
                'scope' => json_encode($scope),
                'language_code' => $language_code
            ]
        );
    }

    public function getFullChatMember($chat_id, $user_id)
    {
        return $this->api->getFullChatMember($chat_id, $user_id);
    }

    /**
     * @param string $inlineQueryId
     * @param AbstractInlineQueryResult[] $results
     * @param int $cacheTime
     * @param bool $isPersonal
     * @param string $nextOffset
     * @param array|null $button
     * @return mixed|null
     */
    public function answerInlineQuery(
        string $inlineQueryId,
        array $results,
        int $cacheTime = 60,
        bool $isPersonal = false,
        string $nextOffset = '',
        array $button = null
    ): mixed
    {
        try {
            $results = array_map(
            /**
             * @param AbstractInlineQueryResult $item
             * @return array
             */
                function ($item) {
                    /** @var array $array */
                    $array = $item->toJson(true);

                    return $array;
                },
                $results
            );


            if (!empty($button)) {
                $button = json_encode($button);
            }

            return $this->api->call('answerInlineQuery', [
                'inline_query_id' => $inlineQueryId,
                'results' => json_encode($results),
                'cache_time' => $cacheTime,
                'is_personal' => $isPersonal,
                'next_offset' => $nextOffset,
                'button' => $button,
            ]);
        } catch (\TelegramBot\Api\Exception $e) {
//            Log::error($e);
            return null;
        }
    }

    public function getChatMember($chat_id, $user_id)
    {
        return $this->api->getChatMember($chat_id, $user_id);
    }
}
