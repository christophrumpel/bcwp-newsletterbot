<?php

namespace App\Conversations;

use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;

class FaqPrizeConversation extends Conversation
{

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->say('The prize has not been set yet.');
    }

}
