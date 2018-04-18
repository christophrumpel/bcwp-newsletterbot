<?php

namespace App\Conversations;

use App\User;
use BotMan\BotMan\Messages\Conversations\Conversation;

class PrivacyPolicyInfoConversation extends Conversation
{

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->showStoredData();
    }

    /**
     */
    public function showStoredData()
    {
        $currentUser = User::where('fb_id', $this->bot->getUser()->getId())->first();

        if($currentUser) {
            $this->bot->reply('Sure. Here is what of your data we got stored:');
            $this->bot->typesAndWaits(1);
            $this->bot->reply('Name: ' . $currentUser->first_name . ' ' . $currentUser->last_name . "\nFacebook Scoped User ID: " . $currentUser->fb_id);
            $this->bot->typesAndWaits(1);
            $this->bot->reply('It is the minimum information we need in order to send you updates.');

        } else {
            $this->bot->typesAndWaits(1);
            $this->bot->reply('We haven\'t saved any information about you yet or you already requested to delete it. 👍');
        }
    }
}
