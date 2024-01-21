<?php

namespace App\Jobs;

use App\Models\Send;
use App\Models\TgUser;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $send;

    public $tries = 1;

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
        $users = [];

        if ($this->send->recipients['type'] == 'all') {
            $users = TgUser::query()
                ->where('banned', 0)
                ->where('is_banned', 0)
                ->get();
        }

        if ($this->send->recipients['type'] == 'lang') {
            $users = TgUser::query()
                ->where('banned', 0)
                ->where('is_banned', 0)
                ->whereIn('language_id', $this->send->recipients['langs'])
                ->get();
        }

        $i = 0;
        foreach ($users as $user) {
            if (is_integer($user)) {
                $user_id = $user;
            } else {
                $user_id = $user->id;
            }
            $i++;
            if ($i > 5) {
                $this->send->refresh();
                if ($this->send->is_active == 0) {
                    break;
                }
                $i = 0;
            }

            SendUnitJob::dispatch(
                $user_id,
                $this->send->id,
            )->onQueue('default');
        }
    }
}
