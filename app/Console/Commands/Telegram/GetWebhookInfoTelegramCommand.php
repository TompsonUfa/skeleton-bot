<?php

namespace App\Console\Commands\Telegram;

use App\Services\Telegram\Api\Api;
use Illuminate\Console\Command;

class GetWebhookInfoTelegramCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:getwebhookinfo';

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
        $bot = new Api();
        $res = $bot->getWebhookInfo()->toJson();
        $this->info($res);
        return 0;
    }
}
