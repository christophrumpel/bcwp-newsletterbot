<?php

namespace App\Newsletters;

use App\User;

class Newsletter6 implements Newsletter
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
            'Hello!',
            'This will be the last time you hear from me before the release of the book on the 12th of July. It means only 11 more nights :-) 😱',
            'Today I can share some big news with you. Christoph already told you about the content of the book, but he never told you what you are going to build in the final chapter. Today I can tell you:',
            '*You are going to develop the Laracon EU chatbot together with Christoph!* ❤️',
            'The Laracon EU is the biggest Laravel conference in Europe. This year it will get its own chatbot, and you are going to build it together from scratch in the book.',
            'Christoph is pleased the project is not going to be another test or fictitious project. It will be a real chatbot project with a real client. You will love it!',
            'Hope you are excited and see you after 11 more nights 🤗'
        ];
    }

}
