<?php

namespace App\Conversations;

use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;

class FallbackConversation extends Conversation
{

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->showFallbackInfo();
    }

    /**
     * First question
     */
    public function showFallbackInfo()
    {
        $this->bot->reply('Hey!');
        $this->bot->typesAndWaits(1);
        $this->bot->reply('I see those words of yours, but I have no idea what they mean. 🤔');
        $this->bot->typesAndWaits(1);
        $this->bot->reply('Christoph said I need to focus on telling you about his book development for now. Maybe later he will train me to understand your messages as well. I hope so ☺️');

        $this->bot->typesAndWaits(1);

        $question = ButtonTemplate::create('Here is how I can help you:')->addButtons([
            ElementButton::create('💌 Edit subscription')->type('postback')->payload('subscribe'),
            ElementButton::create('👉 Christoph\'s Blog')->url('https://christoph-rumpel.com/')
        ]);

        $this->bot->reply($question);
    }
}
