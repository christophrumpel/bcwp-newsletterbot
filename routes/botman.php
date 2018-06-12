<?php

use App\Conversations\FaqContentConversation;
use App\Conversations\FaqPrizeConversation;
use App\Conversations\FaqReleaseConversation;
use App\Conversations\FaqWhoIsItForConversation;
use BotMan\BotMan\BotMan;
use App\Conversations\FallbackConversation;
use App\Conversations\SubscribeConversation;
use App\Conversations\PrivacyPolicyInfoConversation;
use App\Conversations\PrivacyPolicyDeleteDataConversation;
use BotMan\BotMan\Middleware\Dialogflow;

$botman = resolve('botman');

$dialogflow = Dialogflow::create(getenv('DIALOGFLOW_TOKEN'))->listenForAction();
$botman->middleware->received($dialogflow);

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


$botman->group(['middleware' => $dialogflow], function (BotMan $bot) {

    $bot->hears('faq.whoisitfor', function (BotMan $bot) {
        $bot->startConversation(new FaqWhoIsItForConversation());
    })->stopsConversation();

    $bot->hears('faq.content', function (BotMan $bot) {
        $bot->startConversation(new FaqContentConversation());
    })->stopsConversation();

    $bot->hears('faq.prize', function (BotMan $bot) {
        $bot->startConversation(new FaqPrizeConversation());
    })->stopsConversation();

    $bot->hears('faq.release', function (BotMan $bot) {
        $bot->startConversation(new FaqReleaseConversation());
    })->stopsConversation();

});

