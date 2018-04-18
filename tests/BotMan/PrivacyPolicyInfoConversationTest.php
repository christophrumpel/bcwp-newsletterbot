<?php

namespace Tests\BotMan;

use App\User;
use Tests\TestCase;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PrivacyPolicyInfoConversationTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function it_shows_given_user_data()
    {
        $this->createTestUser();

        $this->bot->receives('SHOW_USER_DATA')
            ->assertReplies([
                'Sure. Here is what of your data we got stored:',
                'Name: John Doe'."\nFacebook Scoped User ID: 1",
                'It is the minimum information we need in order to send you updates.',
            ]);
    }

    /**
     * @test
     */
    public function it_tells_user_not_given()
    {
        $this->bot->receives('SHOW_USER_DATA')
            ->assertReply('We haven\'t saved any information about you yet or you already requested to delete it. 👍');
    }

}
