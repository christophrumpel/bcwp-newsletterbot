<?php

namespace App\Newsletters;

use App\User;

class Newsletter5 implements Newsletter
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
            'Aloha '.$user->first_name.' 🤙! Christoph spent some days at the sea in Portugal.',
            $this->newsletterHelper->getImageTemplate('test',
                'https://gallery.mailchimp.com/c9b366927da1fe9e64cd96c9c/images/b603b3b1-8bf8-41dc-b15b-c6b6d482cf85.jpg'),
            'While he was waiting for some waves, he realized that you have been waiting for new book content much too long as well!',
            'Today you can grab the new sample chapter called *Build Your First Chatbot in Plain PHP*!',
            "In this chapter, Christoph explains to you how messenger chatbots work, and how you can build these applications in just plain PHP. It will give you a better understanding of essential chatbot and messenger concepts.\n ✨ *Download it here* 👉 https://goo.gl/ZU9Cfr ✨",
            'Read you soon, bye 👋️',
        ];
    }

    /**
     * @return array
     */
    private function getArticleData()
    {
        return [
            'title' => 'Make Your Chatbots GDPR Compliant',
            'url' => 'https://christoph-rumpel.com/2018/04/make-your-chatbots-gdpr-compliant',
            'imageUrl' => 'https://christoph-rumpel.com/images/blog/headers/blog_header_gdpr.png',

        ];
    }

}
