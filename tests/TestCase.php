<?php

namespace Tests;

use App\User;
use App\BotManTester;
use BotMan\BotMan\BotMan;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @var BotMan
     */
    protected $botman;

    /**
     * @var BotManTester
     */
    protected $bot;

    protected function createTestUser
    ()
    {
        User::insert(['fb_id' => 1, 'first_name' => 'John', 'last_name' => 'Doe']);
    }
}
