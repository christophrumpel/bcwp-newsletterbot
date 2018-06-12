<?php

namespace App\Conversations;

use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;

class FaqReleaseConversation extends Conversation
{

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->say('The book will be released on the 12th of July 🎉. Party! 🎈 ');
    }

}
