<?php

namespace App\Newsletters;

use App\User;

class Newsletter7 implements Newsletter
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
            "Hey {$user->first_name} 👋",
            '*Today is THE DAY! 🎉 🎈*',
            'Christoph just released his book *Build Chatbots with PHP*, and it is now available. With over 200 pages it covers everything you need to know about building chatbots in PHP.',
            'Here is what his friend *Marcel Pociot* says about it:',
            '_"Christoph\'s Chatbot book is a great way to enter the world of chatbots with PHP. It covers everything to get your first chatbot up and running and will leave you inspired to build your own."_',
            'Next to the book, Christoph also provides a little video course showing how to built the Laracon EU chatbot 👍',
            'He also wanted to say thank *YOU* for your patience and support.',
            'As a little gift, he got this 15% discount coupon code for you:',
            '_IT-WAS-A-GREAT-IDEA-TO-SIGN-UP-FOR-THE-NEWSLETTER_',
            $this->newsletterHelper->getSingleArticleTemplate($this->getArticleData()),
        ];
    }

    /**
     * @return array
     */
    private function getArticleData()
    {
        return [
            'title' => 'Build Chatbots with PHP',
            'url' => 'https://store.christoph-rumpel.com/',
            'imageUrl' => 'https://coachtestprep.s3.amazonaws.com/uploads/product/header_image/10536/thumb_book_mockup_v2.png',
            'button' => 'VIEW PACKAGES'

        ];
    }

}
