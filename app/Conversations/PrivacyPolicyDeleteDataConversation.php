<?php

namespace App\Conversations;

use App\User;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Conversations\Conversation;

class PrivacyPolicyDeleteDataConversation extends Conversation
{
    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askAboutDeletion();
    }

    /**
     */
    private function askAboutDeletion()
    {
        $question = Question::create('Are you sure you want to delete your data? As a result, you will no longer receive news on the book.')
            ->
            addButtons([
                Button::create('Yes, I am sure!')
                    ->value('delete'),
                Button::create('Nevermind! Keep it.')
                    ->value('keep'),
            ]);

        $this->bot->typesAndWaits(1);

        $this->ask($question, function (Answer $answer) {
            if ($answer->getValue() === 'delete') {
                $this->deleteUserData();
            } else {
                $this->bot->typesAndWaits(1);
                $this->bot->reply('Ok no problem. I am glad you\'re staying :-) I will take good care of your data.');
            }
        });
    }

    private function deleteUserData()
    {
        $currentUser = User::where('fb_id', $this->bot->getUser()
            ->getId())
            ->first();

        if ($currentUser) {
            $currentUser->delete();
            $this->bot->typesAndWaits(1);
            $this->bot->reply('All of your stored data has been deleted and you will no longer receive news about the book. If you change your mind, you can subscribe again by typing "subscribe".');
        } else {
            $this->bot->typesAndWaits(1);
            $this->bot->reply('We haven\'t saved any information about you yet or you already requested to delete it');
        }
    }
}
