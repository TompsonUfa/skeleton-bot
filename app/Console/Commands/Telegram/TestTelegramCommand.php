<?php

namespace App\Console\Commands\Telegram;

use App\Services\Telegram\Api\Api;
use Illuminate\Console\Command;

class TestTelegramCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $api = new Api();

        $message = '<code>test</code>';
        $api->api->sendMessage('544616196', $message, 'html');

        return 0;
    }
}
