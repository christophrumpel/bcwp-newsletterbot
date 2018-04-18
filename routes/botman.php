<?php

use BotMan\BotMan\BotMan;
use App\Conversations\FallbackConversation;
use App\Http\Middleware\SaveUserMiddleware;
use App\Conversations\SubscribeConversation;
use App\Conversations\PrivacyPolicyInfoConversation;
use App\Conversations\PrivacyPolicyDeleteDataConversation;

$botman = resolve('botman');

//$middleware = new SaveUserMiddleware();
//$botman->middleware->heard($middleware);

$botman->hears('GET_STARTED_NOW|subscribe', function (BotMan $bot) {
    $userFromStartButton = $bot->getMessage()->getText() === 'GET_STARTED_NOW' ? true : false;
    $bot->startConversation(new SubscribeConversation($userFromStartButton));
});

$botman->hears('SHOW_USER_DATA', function(BotMan $bot) {
    $bot->startConversation(new PrivacyPolicyInfoConversation);
})->stopsConversation();

$botman->hears('DELETE_USER_DATA', function(BotMan $bot) {
    $bot->startConversation(new PrivacyPolicyDeleteDataConversation());
})->stopsConversation();

$botman->fallback(function(BotMan $bot) {
    $bot->startConversation(new FallbackConversation());
});

