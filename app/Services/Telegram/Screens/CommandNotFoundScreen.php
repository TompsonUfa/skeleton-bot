<?php


namespace App\Services\Telegram\Screens;


class CommandNotFoundScreen extends AbstractScreen
{

    public function index()
    {
        $this->api->sendMessage('Command not found');
        return false;
    }

    public function handle()
    {

    }

}
