<?php

namespace App\Http\Conversations;

use App\User;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class SubscribeConversation extends Conversation
{
    /**
     * @var bool
     */
    private $userFromStartButton;

    public function __construct(bool $userFromStartButton) {

        $this->userFromStartButton = $userFromStartButton;
    }
    /**
     * Start the conversation.
     *
     * @return mixed
     */
    public function run()
    {
        $this->userFromStartButton ? $this->welcome() : $this->askAboutSubscription();
    }

    private function welcome()
    {
        $this->bot->reply('Hey and welcome! 👋');

        $this->askAboutSubscription();
    }

    private function askAboutSubscription()
    {
        $this->bot->typesAndWaits(.5);
        $this->bot->reply('I help Christoph to spread some news about his book development. 📘');
        $this->bot->typesAndWaits(1);
        $this->bot->reply('If you like, I can keep you updated about it here on Facebook Messenger.');
        $this->bot->typesAndWaits(1);

        $question = Question::create('Are you in?')
            ->addButtons([
                Button::create('Yes please')
                    ->value('yes'),
                Button::create('Nope')
                    ->value('no'),
            ]);

        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'yes') {
                User::subscribe($answer->getMessage()->getSender());
                $this->bot->reply('Woohoo, great to have you on board! 🎉');
                $this->bot->typesAndWaits(.5);
                $this->bot->reply('I will message you when there is something new to tell ✌️');
                $this->bot->typesAndWaits(.5);
            } else {
                User::unsubscribe($answer->getMessage()->getSender());
                $this->bot->typesAndWaits(1);
                $this->bot->reply('Ok no problem. If you change your mind, just type "subscribe".');
            }

            $this->bot->typesAndWaits(1);
            $this->bot->reply("Christoph also likes to blog a lot. Make sure to check out his site for more chatbot stuff: \n ✨ https://christoph-rumpel.com/ ✨ ");
            $this->bot->typesAndWaits(1);
            $this->bot->reply('See you! 👋');
        });
    }

}
