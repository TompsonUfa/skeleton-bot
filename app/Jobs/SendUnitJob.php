<?php

namespace App\Jobs;

use App\Models\Send;
use App\Models\TgUser;
use App\Services\Telegram\Api\Api;
use App\Services\Telegram\Screens\SendScreen;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendUnitJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ?TgUser $user;
    private ?Send $send;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $send_id)
    {

        $this->send = Send::query()
            ->find($send_id);
        $this->user = TgUser::query()
            ->find($user_id);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $api = new Api();
        $screen = new SendScreen();
        $screen->setService($api);

        $api->setUserModel($this->user);
        $screen->setUser($this->user);
        try {
            $units = $this->send->units_();
            $screen->sendUnits($units, $this->send->id);
        } catch (\Exception $e) {
        }
    }
}
