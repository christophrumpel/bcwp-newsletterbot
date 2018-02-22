<?php

namespace App\Console\Commands;

use App\User;
use BotMan\Drivers\Facebook\FacebookDriver;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SendOutNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send newsletter to all subscribers';

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
     * @return mixed
     */
    public function handle()
    {
        $this->info('----- START CRON '.Carbon::now()
                ->toDateTimeString().' -----');
        // init botman
        $botman = app('botman');
        $notifiedUserCount = 0;

        $users = User::where('fb_id', '1310518039047852')
            ->get();

        $users->each(function ($user) use ($botman, &$notifiedUserCount){
            try {
                $botman->say('Hi, here are the latest news', $user->fb_id, FacebookDriver::class);
                $botman->say('1. Chatbots are here to stay', $user->fb_id, FacebookDriver::class);
                $botman->say('2. Self-service is the new thing', $user->fb_id, FacebookDriver::class);
                $botman->say('3. in 2020 20% of companies will have a chatbo!', $user->fb_id, FacebookDriver::class);
                $notifiedUserCount++;
            } catch (\Exception $e) {
                $this->info('FAIL sending message to '.$user->fb_id);
                $this->info($e->getCode().': '.$e->getMessage());
            }
        });

        $this->info('Success. '.$notifiedUserCount.' user were notified!');
        $this->info('----- END CRON '.Carbon::now()
                ->toDateTimeString().' -----');
    }
}
