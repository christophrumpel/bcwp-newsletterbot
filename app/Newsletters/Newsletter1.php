<?php

namespace App\Newsletters;

use App\User;

class Newsletter1 implements Newsletter
{
    /**
     * @var SendNewsletterHelper
     */
    private $newsletterHelper;

    /**
     * Newsletter1 constructor.
     *
     * @param SendNewsletterHelper $newsletterHelper
     */
    public function __construct(SendNewsletterHelper $newsletterHelper)
    {
        $this->newsletterHelper = $newsletterHelper;
    }

    /**
     * @param bool $debug
     * @param $command
     */
    public function send(bool $debug, $command)
    {
        $this->newsletterHelper->sendOutput('START', $command);

        $notifiedUserCount = 0;
        $subscribers = User::getSubscribers($debug);

        $subscribers->each(function ($user) use (&$notifiedUserCount, $command) {
            $notifiedUserCount += $this->newsletterHelper->sendMessages($this->getMessages($user), $user, $command);
        });

        $command->info('Success. '.$notifiedUserCount.' user were notified!');
        $this->newsletterHelper->sendOutput('END', $command);
    }

    /**
     * @param User $user
     * @return array
     */
    public function getMessages(User $user)
    {
        return [
            'Hey '.$user->first_name.'! Christoph got some news for you.',
            'He finally finished the whole first chapter 🎉 I just checked it. Looks good to me ;-)',
            $this->newsletterHelper->getImageTemplate('He just finished the whole first chapter of the book 🎉',
                'https://gallery.mailchimp.com/c9b366927da1fe9e64cd96c9c/images/6ea238bb-6676-40f0-a6a9-47957ac02f64.jpg'),
            'It seems that the free sample chapter has been updated as well. You can download it here: https://goo.gl/u3wQNW',
            'Additionally, Christoph also wanted you to check out these new articles. That\'s it for today. See you next time again ✌️',
            $this->newsletterHelper->getArticlesTemplate($this->getArticlesData()),
        ];
    }

    /**
     * @return array
     */
    private function getArticlesData()
    {
        return [
            [
                'title' => '✨ Build a newsletter chatbot in PHP - Part 1 ✨',
                'subTitle' => 'Email has been a great channel for staying in touch with your audience for years.',
                'url' => 'https://christoph-rumpel.com/2018/02/build-a-newsletter-chatbot-in-php-part-1',
                'imageUrl' => 'https://christoph-rumpel.com/images/blog/nl_bot_final.png',
            ],
            [
                'title' => 'How to Write Facebook Messenger Copy That Converts',
                'subTitle' => 'Facebook Messenger marketing is more straightforward than you might think. I’ve built countless bots and ran marketing campaigns at scale that drove great results.',
                'url' => 'https://chatbotsmagazine.com/how-to-write-facebook-messenger-copy-that-converts-9f50f0a80fc4',
                'imageUrl' => 'https://cdn-images-1.medium.com/max/800/1*ktMpD4FOA8JKzItVAd0bGg.jpeg',
            ],
            [
                'title' => 'The BotMan WebDriver explained',
                'subTitle' => 'The WebDriver is one of the best features about the BotMan library. Still I see a lot of people struggling with the concept and how to use it.',
                'url' => 'https://christoph-rumpel.com/2018/02/the-botman-webdriver-explained',
                'imageUrl' => 'https://christoph-rumpel.com/images/blog/wstv_bot.png',
            ],
        ];
    }

}
