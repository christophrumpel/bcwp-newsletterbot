<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('GET_STARTED_NOW', function ($bot) {
    $bot->reply('Hi, it\'s great to have you on board! 🎉');
    $bot->reply('Next time Christoph has some updates on this book, I will help him to keep you informed.');
    $bot->reply('You will get this message right here in your messenger. See you :-)');
});

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');

