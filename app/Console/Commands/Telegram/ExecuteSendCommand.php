<?php

namespace App\Console\Commands\Telegram;

use App\Services\SendService;
use Illuminate\Console\Command;

class ExecuteSendCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sends:exec';

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
        $sendService = new SendService();
        $sendService->execute();
        return 0;
    }
}
