<?php

namespace App\Newsletters;

use App\User;

class Newsletter4 implements Newsletter
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
            'Hello '.$user->first_name.'! Hope you\'re having such great weather as we do right now in Vienna 😎 ☀️',
            'But back to chatbots! Christoph has spent quite some time on the upcoming GDPR. It\'s a new EU regulation that defines how EU citizen\'s data must be handled. You should make yourself familiar with it, and the best way is by reading this new article Christoph wrote:',
            $this->newsletterHelper->getSingleArticleTemplate($this->getArticleData()),
            "As Christoph is already working on the final chapters, the table of contents is almost finished. Find the updated version on the website:\n ✨ https://christoph-rumpel.com/build-chatbots-with-php",
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
