<?php

namespace App\Services\Telegram\Api;


use TelegramBot\Api\Types\Message;
use TelegramBot\Api\Exception;
use TelegramBot\Api\HttpException;
use TelegramBot\Api\InvalidArgumentException;
use TelegramBot\Api\InvalidJsonException;

class BotApi extends \TelegramBot\Api\BotApi
{

    public function __construct($token, $trackerToken = null)
    {
        parent::__construct($token, $trackerToken);
    }

    public function call($method, array $data = null, $timeout = 30)
    {
        return parent::call($method, $data, $timeout);
    }


    public function answerCallbackQuery($callbackQueryId, $text = null, $showAlert = false,
                                        $url = null, $cacheTime = 0)
    {
        try {
            return $this->call('answerCallbackQuery', [
                'callback_query_id' => $callbackQueryId,
                'text' => $text,
                'show_alert' => (bool)$showAlert,
                'url' => $url,
                'cache_time' => $cacheTime,
            ]);
        } catch (\Exception $e) {}

    }

    /**
     * As of v.4.0, Telegram clients support rounded square mp4 videos of up to 1 minute long.
     * Use this method to send video messages.
     * On success, the sent Message is returned.
     *
     * @param int|string $chatId chat_id or @channel_name
     * @param \CURLFile|string $videoNote
     * @param null $duration
     * @param null $length
     * @param null $replyToMessageId
     * @param null $replyMarkup
     * @param bool $disableNotification
     * @param null $messageThreadId
     * @param null $protectContent
     * @param null $allowSendingWithoutReply
     * @param null $thumbnail
     *
     * @return Types\Message
     * @throws Exception
     * @throws InvalidArgumentException
     * @throws HttpException
     * @throws InvalidJsonException
     */
    public function sendVideoNote(
        $chatId,
        $videoNote,
        $duration = null,
        $length = null,
        $replyToMessageId = null,
        $replyMarkup = null,
        $disableNotification = false,
        $messageThreadId = null,
        $protectContent = null,
        $allowSendingWithoutReply = null,
        $thumbnail = null
    ): Types\Message
    {
        return Types\Message::fromResponse($this->call('sendVideoNote', [
            'chat_id' => $chatId,
            'video_note' => $videoNote,
            'duration' => $duration,
            'length' => $length,
            'message_thread_id' => $messageThreadId,
            'reply_to_message_id' => $replyToMessageId,
            'reply_markup' => is_null($replyMarkup) ? $replyMarkup : $replyMarkup->toJson(),
            'disable_notification' => (bool) $disableNotification,
            'protect_content' => (bool) $protectContent,
            'allow_sending_without_reply' => (bool) $allowSendingWithoutReply,
            'thumbnail' => $thumbnail,
        ]));
    }

    public function getFullChatMember($chatId, $userId)
    {
        return Types\ChatMember::fromResponse($this->call('getChatMember', [
            'chat_id' => $chatId,
            'user_id' => $userId
        ]));
    }

}
