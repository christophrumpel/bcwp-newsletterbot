<?php

namespace App\Console\Commands;

use App\User;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Facebook\Extensions\Element;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\Drivers\Facebook\Extensions\GenericTemplate;
use BotMan\Drivers\Facebook\Extensions\ListTemplate;
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
    protected $signature = 'newsletter:send {debug?}';

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
     */
    public function handle()
    {
        // init botman
        /** @var BotMan $botman */
        $botman = app('botman');
        $notifiedUserCount = 0;

        $subscribers = $this->getSubscribers($this->argument('debug'));

        $this->sendInfo('START');

        $subscribers->each(function ($user) use ($botman, &$notifiedUserCount) {
            try {
                collect($this->getMessages($user))->each(function ($message) use ($botman, $user, &$notifiedUserCount) {
                    $botman->say($message, $user->fb_id, FacebookDriver::class);
                });

                $notifiedUserCount++;
            } catch (\Exception $e) {
                $this->info('FAIL sending message to '.$user->fb_id);
                $this->info($e->getCode().': '.$e->getMessage());
            }
        });

        $this->info('Success. '.$notifiedUserCount.' user were notified!');
        $this->sendInfo('END');
    }

    /**
     * Get subscribers or admin if it is for debugging
     *
     * @param null $debug
     * @return mixed
     */
    private function getSubscribers($debug = null)
    {
        if ($debug) {
            return User::where('admin', true)
                ->get();
        }

        return User::where('subscribed', true)
            ->get();
    }

    /**
     * List all messages
     *
     * @param User $user
     * @return array
     */
    private function getMessages(User $user)
    {
        return [
            'Hey '.$user->first_name.'! Christoph got some news for you.',
            'He finally finished the whole first chapter 🎉 I just checked it. Looks good to me ;-)',
            $this->getImageTemplate(),
            'It seems that the free sample chapter has been updated as well. You can download it here: https://goo.gl/u3wQNW',
            'Additionally, Christoph also wanted you to check out these new articles. That\'s it for today. See you next time again ✌️',
            $this->getArticlesTemplate(),
        ];
    }

    /**
     * @return OutgoingMessage
     */
    private function getImageTemplate()
    {
        return OutgoingMessage::create('He just finished the whole first chapter of the book 🎉')
            ->withAttachment(Image::url('https://gallery.mailchimp.com/c9b366927da1fe9e64cd96c9c/images/6ea238bb-6676-40f0-a6a9-47957ac02f64.jpg'));
    }

    /**
     * @return ListTemplate
     */
    private function getArticlesTemplate()
    {
        return ListTemplate::create()
            ->addElements([
                Element::create('✨ Build a newsletter chatbot in PHP - Part 1 ✨')
                    ->subtitle('Email has been a great channel for staying in touch with your audience for years.')
                    ->addButton(ElementButton::create('Visit')
                        ->url('https://christoph-rumpel.com/2018/02/build-a-newsletter-chatbot-in-php-part-1'))
                    ->image('https://christoph-rumpel.com/images/blog/nl_bot_final.png'),
                Element::create('How to Write Facebook Messenger Copy That Converts')
                    ->subtitle('Facebook Messenger marketing is more straightforward than you might think. I’ve built countless bots and ran marketing campaigns at scale that drove great results.')
                    ->addButton(ElementButton::create('Visit')
                        ->url('https://chatbotsmagazine.com/how-to-write-facebook-messenger-copy-that-converts-9f50f0a80fc4'))
                    ->image('https://cdn-images-1.medium.com/max/800/1*ktMpD4FOA8JKzItVAd0bGg.jpeg'),
                Element::create('The BotMan WebDriver explained')
                    ->subtitle('The WebDriver is one of the best features about the BotMan library. Still I see a lot of people struggling with the concept and how to use it.')
                    ->addButton(ElementButton::create('Visit')
                        ->url('https://christoph-rumpel.com/2018/02/the-botman-webdriver-explained'))
                    ->image('https://christoph-rumpel.com/images/blog/wstv_bot.png'),

            ]);
    }

    /**
     * @param string $message
     */
    private function sendInfo(string $message)
    {
        $this->info('----- '.$message.' CRON '.Carbon::now()
                ->toDateTimeString().' -----');
    }

    //private function getSampleChapterTemplate()
    //{
    //    return GenericTemplate::create()
    //        ->addElement(Element::create('Free Sample Chapter')
    //            ->image('https://christoph-rumpel.com/images/book/book_v1.png')
    //            ->addButton(ElementButton::create('Download Now')->url('https://gallery.mailchimp.com/c9b366927da1fe9e64cd96c9c/files/e314bfd3-cf44-42d3-ba86-f9c9b105a03f/build_chatbots_with_php_preview_v3.pdf')));
    //}

}
