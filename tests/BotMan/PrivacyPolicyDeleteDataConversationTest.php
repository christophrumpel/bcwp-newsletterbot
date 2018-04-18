<?php

namespace Tests\BotMan;

use App\User;
use Tests\TestCase;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PrivacyPolicyDeleteDataConversationTest extends TestCase
{

    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_asks_about_deletion_but_not_user_given()
    {
        $question = Question::create('Are you sure you want to delete your data? As a result, you will no longer receive news on the book.')
            ->addButtons([
                Button::create('Yes, I am sure!')
                    ->value('delete'),
                Button::create('Nevermind! Keep it.')
                    ->value('keep'),
            ]);

        $this->bot->receives('DELETE_USER_DATA')
            ->assertTemplate($question, true)
            ->receives('delete')
            ->assertReply('We haven\'t saved any information about you yet or you already requested to delete it');
    }

    /**
     * @test
     */
    public function it_asks_about_deletion_and_shows_positive_answer()
    {
        $question = Question::create('Are you sure you want to delete your data? As a result, you will no longer receive news on the book.')
            ->addButtons([
                Button::create('Yes, I am sure!')
                    ->value('delete'),
                Button::create('Nevermind! Keep it.')
                    ->value('keep'),
            ]);

        User::insert(['fb_id' => 1, 'first_name' => 'John', 'last_name' => 'Dow']);

        $this->bot->receives('DELETE_USER_DATA')
            ->assertTemplate($question, true)
            ->receives('delete')
            ->assertReply('All of your stored data has been deleted and you will no longer receive news about the book. If you change your mind, you can subscribe again by typing "subscribe".');
    }

    /**
     * @test
     */
    public function it_asks_about_deletion_and_shows_negative_answer()
    {
        $question = Question::create('Are you sure you want to delete your data? As a result, you will no longer receive news on the book.')
            ->addButtons([
                Button::create('Yes, I am sure!')
                    ->value('delete'),
                Button::create('Nevermind! Keep it.')
                    ->value('keep'),
            ]);

        $this->createTestUser();

        $this->bot->receives('DELETE_USER_DATA')
            ->assertTemplate($question, true)
            ->receives('keep')
            ->assertReply('Ok no problem. I am glad you\'re staying :-) I will take good care of your data.');
    }
}
