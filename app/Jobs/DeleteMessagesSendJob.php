<?php

namespace App\Jobs;

use App\Models\Send;
use App\Models\SendHistory;
use App\Models\TgUser;
use App\Services\Telegram\Api\Api;
use App\Services\Telegram\Screens\SendScreen;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeleteMessagesSendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $send;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($send_id)
    {
        $this->send = Send::query()
            ->find($send_id);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $histories = SendHistory::query()
            ->where('send_id', $this->send->id)
            ->get();

        $api = new Api();
        $screen = new SendScreen();
        $screen->setService($api);
        foreach ($histories as $history) {
            $user = TgUser::find($history->tg_user_id);
            $api->setUserModel($user);
            $screen->setUser($user);
            try {
                $screen->deleteMessage($history->message_id);
            } catch (\Exception $e) {
            }
        }
    }
}
