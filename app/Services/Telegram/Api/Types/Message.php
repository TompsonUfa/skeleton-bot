<?php

namespace App\Services\Telegram\Api\Types;

use TelegramBot\Api\Types\ArrayOfUser;
use TelegramBot\Api\Types\Dice;
use TelegramBot\Api\Types\ForumTopicClosed;
use TelegramBot\Api\Types\ForumTopicCreated;
use TelegramBot\Api\Types\ForumTopicReopened;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\Payments\Invoice;
use TelegramBot\Api\Types\Payments\SuccessfulPayment;
use TelegramBot\Api\Types\Animation;
use TelegramBot\Api\Types\ArrayOfMessageEntity;
use TelegramBot\Api\Types\ArrayOfPhotoSize;
use TelegramBot\Api\Types\Audio;
use TelegramBot\Api\Types\Chat;
use TelegramBot\Api\Types\Contact;
use TelegramBot\Api\Types\Document;
use TelegramBot\Api\Types\Location;
use TelegramBot\Api\Types\Poll;
use TelegramBot\Api\Types\Sticker;
use TelegramBot\Api\Types\User;
use TelegramBot\Api\Types\Venue;
use TelegramBot\Api\Types\Video;
use TelegramBot\Api\Types\VideoNote;
use TelegramBot\Api\Types\Voice;
use TelegramBot\Api\Types\WebAppData;

class Message extends \TelegramBot\Api\Types\Message
{
    /**
     * {@inheritdoc}
     *
     * @var array
     */
    protected static $requiredParams = ['message_id', 'date', 'chat'];

    /**
     * {@inheritdoc}
     *
     * @var array
     */
    protected static $map = [
        'message_id' => true,
        'from' => User::class,
        'date' => true,
        'chat' => Chat::class,
        'forward_from' => User::class,
        'forward_from_chat' => Chat::class,
        'forward_from_message_id' => true,
        'forward_date' => true,
        'forward_signature' => true,
        'forward_sender_name' => true,
        'reply_to_message' => Message::class,
        'via_bot' => User::class,
        'edit_date' => true,
        'media_group_id' => true,
        'author_signature' => true,
        'text' => true,
        'entities' => ArrayOfMessageEntity::class,
        'caption_entities' => ArrayOfMessageEntity::class,
        'audio' => Audio::class,
        'document' => Document::class,
        'animation' => Animation::class,
        'photo' => ArrayOfPhotoSize::class,
        'sticker' => Sticker::class,
        'video' => Video::class,
        'video_note' => VideoNote::class,
        'voice' => Voice::class,
        'caption' => true,
        'contact' => Contact::class,
        'location' => Location::class,
        'venue' => Venue::class,
        'poll' => Poll::class,
        'dice' => Dice::class,
        'new_chat_members' => ArrayOfUser::class,
        'left_chat_member' => User::class,
        'new_chat_title' => true,
        'new_chat_photo' => ArrayOfPhotoSize::class,
        'delete_chat_photo' => true,
        'group_chat_created' => true,
        'supergroup_chat_created' => true,
        'channel_chat_created' => true,
        'migrate_to_chat_id' => true,
        'migrate_from_chat_id' => true,
        'pinned_message' => Message::class,
        'invoice' => Invoice::class,
        'successful_payment' => SuccessfulPayment::class,
        'connected_website' => true,
        'forum_topic_created' => ForumTopicCreated::class,
        'forum_topic_closed' => ForumTopicClosed::class,
        'forum_topic_reopened' => ForumTopicReopened::class,
        'is_topic_message' => true,
        'message_thread_id' => true,
        'web_app_data' => WebAppData::class,
        'reply_markup' => InlineKeyboardMarkup::class,
    ];

    /**
     * Optional. Message is a video note, information about the video note
     *
     * @var \TelegramBot\Api\Types\VideoNote|null
     */
    protected $videoNote;

    /**
     * @return VideoNote|null
     */
    public function getVideoNote()
    {
        return $this->videoNote;
    }

    /**
     * @param Video $video
     * @return void
     */
    public function setVideoNote(VideoNote $videoNote)
    {
        $this->videoNote = $videoNote;
    }
}
