<?php

namespace App\Console\Commands;

use App\Newsletters\Newsletter;
use App\User;
use Illuminate\Console\Command;
use App\Newsletters\SendNewsletterHelper;
use BotMan\Drivers\Facebook\Extensions\ListTemplate;
use BotMan\Drivers\Facebook\Extensions\ElementButton;

class SendOutNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send {version} {--debug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send specific newsletter version to subscribers';

    /**
     * @var SendNewsletterHelper
     */
    private $sendNewsletterHelper;

    /**
     * Create a new command instance.
     *
     * @param SendNewsletterHelper $sendNewsletterHelper
     */
    public function __construct(SendNewsletterHelper $sendNewsletterHelper)
    {
        parent::__construct();
        $this->sendNewsletterHelper = $sendNewsletterHelper;
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $version = $this->argument('version');
        $className = '\App\Newsletters\Newsletter'.$version;

        /** @var Newsletter $newsletter */
        $newsletter = new $className($this->sendNewsletterHelper);
        $newsletter->send($this->option('debug'), $this);
    }

}
