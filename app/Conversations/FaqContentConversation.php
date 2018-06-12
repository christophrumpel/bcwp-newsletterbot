<?php

namespace App\Conversations;

use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;

class FaqContentConversation extends Conversation
{

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->say('These are the chapters of this book:');
        $this->say("
➡️ Chatbot Basics\n
➡️ The Rise of Chatbots\n
➡️ Why PHP Is A Perfect Fit For Chatbots\n
➡️ Build Your First Chatbot in Plain PHP\n
➡️ Chatbot Frameworks\n
➡️ Chatbots and the GDPR\n
➡️ Let’s Build A Secret Multi-Platform Chatbot with BotMan\n
➡️ Next Steps And Tools\n ");
    }

}
