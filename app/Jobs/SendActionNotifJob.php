<?php

namespace App\Jobs;

use App\Models\TgUser;
use App\Services\Telegram\Api\Api;
use App\Services\Telegram\Screens\SendScreen;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendActionNotifJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ?TgUser $user;
    private int $action;
    private int $step;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id, $action, $step)
    {
        $this->user = TgUser::query()
            ->find($user_id);
        $this->action = $action;
        $this->step = $step;
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
            $screen->sendActionNotification($this->action, $this->step);
        } catch (\Exception $e) {
        }
    }
}
