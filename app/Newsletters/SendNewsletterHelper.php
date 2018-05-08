<?php

namespace App\Newsletters;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Attachments\Attachment;
use BotMan\Drivers\Facebook\Extensions\MediaTemplate;
use Illuminate\Support\Carbon;
use BotMan\Drivers\Facebook\FacebookDriver;
use BotMan\BotMan\Messages\Attachments\Image;
use BotMan\Drivers\Facebook\Extensions\Element;
use BotMan\Drivers\Facebook\Extensions\ListTemplate;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\Drivers\Facebook\Extensions\GenericTemplate;

class SendNewsletterHelper
{

    /**
     * @param string $text
     * @param string $imageUrl
     * @return OutgoingMessage
     */
    public function getImageTemplate(string $text, string $imageUrl)
    {
        return OutgoingMessage::create($text)
            ->withAttachment(Image::url($imageUrl));
    }

    /**
     * @param string $message
     * @param $command
     */
    public function sendOutput(string $message, $command)
    {
        $command->info('----- '.$message.' COMMAND '.Carbon::now()
                ->toDateTimeString().' -----');
    }

    /**
     * @return mixed
     */
    public function getSampleChapterTemplate()
    {
        return GenericTemplate::create()
            ->addElement(Element::create('Free Sample Chapter')
                ->image('https://christoph-rumpel.com/images/book/book_v1.png')
                ->addButton(ElementButton::create('Download Now')
                    ->url('https://gallery.mailchimp.com/c9b366927da1fe9e64cd96c9c/files/e314bfd3-cf44-42d3-ba86-f9c9b105a03f/build_chatbots_with_php_preview_v3.pdf')));
    }

    /**
     * @param array $articles
     * @return ListTemplate
     */
    public function getArticlesTemplate(array $articles)
    {
        $template = ListTemplate::create();

        collect($articles)->each(function ($article) use (&$template) {
            $template->addElement(Element::create($article['title'])
                ->subtitle($article['subTitle'])
                ->addButton(ElementButton::create('Visit')
                    ->url($article['url']))
                ->image($article['imageUrl']));
        });

        return $template;
    }

    /**
     * @param array $article
     * @return GenericTemplate
     */
    public function getSingleArticleTemplate(array $article)
    {
        return GenericTemplate::create()
            ->addElement(Element::create($article['title'])
                ->image($article['imageUrl'])
                ->addButton(ElementButton::create('Visit')
                    ->url($article['url'])));
    }

    /**
     * @param array $messages
     * @param $user
     * @param $command
     * @return int
     */
    public function sendMessages(array $messages, $user, $command)
    {
        /** @var BotMan $botman */
        $botman = app('botman');
        $notifiedUserCount = 0;

        try {
            collect($messages)->each(function ($message) use ($botman, $user, &$notifiedUserCount) {
                $botman->say($message, $user->fb_id, FacebookDriver::class);
            });

            $notifiedUserCount++;
        } catch (\Exception $e) {
            $command->info('FAIL sending message to '.$user->fb_id);
            $command->info($e->getCode().': '.$e->getMessage());
        }

        return $notifiedUserCount;
    }
}