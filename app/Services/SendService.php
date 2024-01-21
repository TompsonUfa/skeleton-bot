<?php


namespace App\Services;


use App\Helpers\BotActionHelper;
use App\Jobs\DeleteMessagesSendJob;
use App\Jobs\SendActionNotifJob;
use App\Jobs\SendJob;
use App\Models\Send;
use App\Models\TgUser;
use Carbon\Carbon;

class SendService
{

    public function execute()
    {
        $sends = Send::query()
            ->where('is_active', 1)
            ->where('is_publish', 0)
            ->where('publish_at', '<', Carbon::now())
            ->get();

        foreach ($sends as $item) {
            $item->is_publish = 1;
            $item->save();
            SendJob::dispatch($item->id);
        }

    }

    public function delete_messages($send_id)
    {
        DeleteMessagesSendJob::dispatch($send_id);
    }

    public function sendActionNotification()
    {
        $users = TgUser::query()
            ->select(['id', 'last_action', 'last_action_time', 'action_notif_step'])
            ->where('is_banned', 0)
            ->where('last_action', '!=', BotActionHelper::OTHER)
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('last_action_time', '<=', now('+3')->setHours(17)->subDay())
                        ->where('action_notif_step', 0);
                })->orWhere(function ($q) {
                    $q->where('last_action_time', '<=', now('+3')->setHours(12)->subDays(3))
                        ->where('action_notif_step', 1);
                });
            })
            ->get();

        /* @var TgUser $user */
        foreach ($users as $user) {
            $user->action_notif_step++;
            $user->save();
            SendActionNotifJob::dispatch($user->id, $user->last_action, $user->action_notif_step);
        }

    }
}
