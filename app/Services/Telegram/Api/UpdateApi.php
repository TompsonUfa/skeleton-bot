<?php

namespace App\Services\Telegram\Api;


use TelegramBot\Api\Types\Chat;
use TelegramBot\Api\Types\User;

class UpdateApi extends \TelegramBot\Api\Types\Update
{

    private User|null $from = null;
    private Chat|null $chat = null;

    /**
     * @var MyChatMember
     */
    protected $myChatMember;

    public function __construct()
    {
        self::$map['my_chat_member'] = MyChatMember::class;
    }

    public function isApprovedData(): bool
    {
        $approve = false;

        if ($this->getMessage() != null) {
            $approve = true;
            $this->from = $this->getMessage()->getFrom();
            $this->chat = $this->getMessage()->getChat();
        }

        if ($this->getCallbackQuery() != null) {
            $approve = true;
            $this->from = $this->getCallbackQuery()->getFrom();
            $this->chat = $this->getCallbackQuery()->getMessage()->getChat();
        }

        if ($this->getInlineQuery() != null) {
            $this->from = $this->getInlineQuery()->getFrom();
            return true;
        }

        if ($this->from == null) {
            return false;
        }

        if ($this->chat == null) {
            return false;
        }

        if ($this->from->isBot()) {
            return false;
        }

        if ($this->chat->getType() != 'private') {
            return false;
        }

        if ($this->chat->getId() != $this->from->getId()) {
            return false;
        }

        return $approve;
    }

    public function getFrom(): User
    {
        return $this->from;
    }

    public function getChat(): Chat
    {
        return $this->chat;
    }

    /**
     * @return MyChatMember|null
     */
    public function getMyChatMember(): MyChatMember|null
    {
        return $this->myChatMember;
    }

    /**
     * @param MyChatMember $message
     */
    public function setMyChatMember(MyChatMember $message)
    {
        $this->myChatMember = $message;
    }
}
