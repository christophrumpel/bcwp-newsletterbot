<?php

namespace Tests\BotMan;

use BotMan\Drivers\Facebook\Extensions\ButtonTemplate;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use Illuminate\Foundation\Inspiring;
use Tests\TestCase;

class FallbackTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     * @test
     */
    public function it_triggers_the_fallback_message()
    {
        $this->bot->receives('What is your name?')
            ->assertReply('Hey!')
            ->assertReply('I see those words of yours, but I have no idea what they mean. 🤔')
            ->assertReply('Christoph said I need to focus on telling you about his book development for now. Maybe later he will train me to understand your messages as well. I hope so ☺️');

        $template = ButtonTemplate::create('Here is how I can help you:')->addButtons([
            ElementButton::create('💌 Edit subscription')->type('postback')->payload('subscribe'),
            ElementButton::create('👉 Christoph\'s Blog')->url('https://christoph-rumpel.com/')
        ]);

        $this->bot->assertTemplate($template, true);
    }
}

