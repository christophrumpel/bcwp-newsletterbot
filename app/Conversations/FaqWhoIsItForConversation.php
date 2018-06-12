<?php

namespace App\Conversations;

use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;

class FaqWhoIsItForConversation extends Conversation
{

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->say("You are the right person for this book if you...\n

➡️ want to learn more about chatbots\n
➡️ you're a PHP developer and want to build a chatbot\n
➡️ are interested in how to setup up a chatbot project from scratch\n
➡️ like to level up as a chatbot developer\n
➡️ want to innovate your company's or client's services\n
➡️  you want to contribute to the future of conversational interfaces");
    }

}
