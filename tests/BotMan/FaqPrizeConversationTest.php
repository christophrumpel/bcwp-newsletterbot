<?php

namespace Tests\BotMan;

use Tests\TestCase;

class FaqPrizeConversationTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_replies_to_faq_action_with_prize_info()
    {
        $this->bot->receives('faq.prize')
            ->assertReply('The prize has not been set yet.');
    }
}

