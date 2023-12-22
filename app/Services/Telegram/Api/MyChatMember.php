<?php

namespace App\Services\Telegram\Api;

use TelegramBot\Api\BaseType;
use TelegramBot\Api\InvalidArgumentException;
use TelegramBot\Api\TypeInterface;
use TelegramBot\Api\Types\Chat;
use TelegramBot\Api\Types\ChatMember;
use TelegramBot\Api\Types\User;

class MyChatMember extends BaseType implements TypeInterface
{
    /**
     * {@inheritdoc}
     *
     * @var array
     */
    static protected $requiredParams = ['from', 'chat'];

    /**
     * {@inheritdoc}
     *
     * @var array
     */
    static protected $map = [
        'from' => User::class,
        'date' => true,
        'chat' => Chat::class,
        'old_chat_member' => ChatMember::class,
        'new_chat_member' => ChatMember::class
    ];

    /**
     * @var User
     */
    protected $from;

    /**
     * @var Chat
     */
    protected $chat;

    /**
     * @var int
     */
    protected $date;

    /**
     * @var ChatMember
     */
    protected $oldChatMember;

    /**
     * @var ChatMember
     */
    protected $newChatMember;

    /**
     * @return User
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param User $from
     */
    public function setFrom(User $from)
    {
        $this->from = $from;
    }

    /**
     * @return Chat
     */
    public function getChat()
    {
        return $this->chat;
    }

    /**
     * @param Chat $chat
     */
    public function setChat(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * @return int
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param int $date
     *
     * @throws InvalidArgumentException
     */
    public function setDate($date)
    {
        if (is_int($date)) {
            $this->date = $date;
        } else {
            throw new InvalidArgumentException();
        }
    }

    /**
     * @return ChatMember
     */
    public function getOldChatMember()
    {
        return $this->oldChatMember;
    }

    /**
     * @param ChatMember $member
     */
    public function setOldChatMember(ChatMember $member)
    {
        $this->oldChatMember = $member;
    }

    /**
     * @return ChatMember
     */
    public function getNewChatMember()
    {
        return $this->newChatMember;
    }

    /**
     * @param ChatMember $member
     */
    public function setNewChatMember(ChatMember $member)
    {
        $this->newChatMember = $member;
    }
}
