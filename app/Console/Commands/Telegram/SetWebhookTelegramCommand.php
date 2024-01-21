<?php

namespace App\Console\Commands\Telegram;

use App\Services\Telegram\Api\Api;
use App\Services\Telegram\Traits\KeyboardsTrait;
use Illuminate\Console\Command;

class SetWebhookTelegramCommand extends Command
{
    use KeyboardsTrait;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'telegram:setwebhook';

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
//        $api = new Api();
//        $res = $api->setWebhook();
//        $api->setMyCommands($this->commands());
//        $this->info(json_encode($res));

        #region set main bot
        $api = new Api();

        if(!empty($api->getWebhookInfo()?->getUrl()))
        {
            $resDeletingWebhook = $api->api->deleteWebhook();
            $this->info('Deleted webhook result: ' . json_encode($resDeletingWebhook));
        }

        $res = $api->setWebhook(
            dropPendingUpdates: true
        );
        $this->info('Setup new webhook: ' . json_encode($res));
        #endregion

        try
        {
            $scopeTypes = [
                'default',
                'all_private_chats',
                'all_group_chats'
            ];

            foreach ($scopeTypes as $scopeType)
            {
                $resDeletingMyCommands = $api->deleteMyCommands(
                    scope: [
                    'type' => $scopeType
                ],
                );

                $this->info("Deleting commands with scope \"$scopeType\" result: " . json_encode($resDeletingMyCommands));
            }
        } catch (\Throwable $e) {
            $this->error($e->getMessage());
        }

        $res = $api->setMyCommands(
            commands: $this->commands(),
            scope: [
                'type' => 'all_private_chats'
            ]
        );

        return 0;
    }
}
