<?php

namespace App\Newsletters;

use App\User;

class Newsletter2 implements Newsletter
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
            'Hey '.$user->first_name.'! Christoph needs your help 🙏',
            "He set up a little 10 question survey to find out more about you and your interest into chatbots. Please take a minute and help make the book a better fit for you: \n✨ Survey: https://goo.gl/Y2tTvR ✨",
            'Christoph is also working hard on the "Build A Newsletter Chatbot in PHP" series. Two articles are already available.',
            $this->newsletterHelper->getArticlesTemplate($this->getArticlesData()),
            'That\'s it for today. See you next time again ✌️',
        ];
    }

    /**
     * @return array
     */
    private function getArticlesData()
    {
        return [
            [
                'title' => 'Build a newsletter chatbot in PHP - Part 1',
                'subTitle' => 'Email has been a great channel for staying in touch with your audience for years.',
                'url' => 'https://christoph-rumpel.com/2018/02/build-a-newsletter-chatbot-in-php-part-1',
                'imageUrl' => 'https://christoph-rumpel.com/images/blog/nl_bot_final.png',
            ],
            [
                'title' => 'Build a newsletter chatbot in PHP - Part 2',
                'subTitle' => 'This is part two of building a newsletter chatbot in PHP. In part one, we already created a little Facebook Messenger chatbot that welcomes you and tells you about the subscriptions process.',
                'url' => 'https://christoph-rumpel.com/2018/02/build-a-newsletter-chatbot-in-php-part-2',
                'imageUrl' => 'https://christoph-rumpel.com/images/blog/nl_bot_final.png',
            ],
        ];
    }

}
