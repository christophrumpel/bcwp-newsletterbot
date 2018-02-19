<?php

namespace App\Http\Middleware;

use App\User;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\Interfaces\Middleware\Heard;
use BotMan\BotMan\Interfaces\Middleware\Received;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;

class SaveUserMiddleware implements Heard
{
    /**
     * Handle a message that was successfully heard, but not processed yet.
     *
     * @param IncomingMessage $message
     * @param callable $next
     * @param BotMan $bot
     *
     * @return mixed
     */
    public function heard(IncomingMessage $message, $next, BotMan $bot)
    {
        // Save user to DB
        $user = $bot->getUser();

        if($user instanceof \BotMan\Drivers\Facebook\Extensions\User) {
            User::createFromIncomingMessage($user);
        }

        return $next($message);
    }
}

