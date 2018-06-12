<?php

namespace Tests\BotMan;

use Tests\TestCase;

class FaqReleaseConversationTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_replies_to_faq_action_with_content()
    {
        $this->bot->receives('faq.release')
            ->assertReply('The book will be released on the 12th of July 🎉. Party! 🎈 ');
    }
}

