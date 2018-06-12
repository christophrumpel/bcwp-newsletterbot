<?php

namespace Tests\BotMan;

use Tests\TestCase;

class FaqContentConversationTest extends TestCase
{
    /**
     * @return void
     * @test
     */
    public function it_replies_to_faq_action_with_content()
    {
        $this->bot->receives('faq.content')->assertReply('These are the chapters of this book:')->assertReply("\n➡️ Chatbot Basics\n
➡️ The Rise of Chatbots\n
➡️ Why PHP Is A Perfect Fit For Chatbots\n
➡️ Build Your First Chatbot in Plain PHP\n
➡️ Chatbot Frameworks\n
➡️ Chatbots and the GDPR\n
➡️ Let’s Build A Secret Multi-Platform Chatbot with BotMan\n
➡️ Next Steps And Tools\n ");
    }
}

