<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Facebook Token
    |--------------------------------------------------------------------------
    |
    | Your Facebook application you received after creating
    | the messenger page / application on Facebook.
    |
    */
    'token' => env('FACEBOOK_TOKEN'),

    /*
    |--------------------------------------------------------------------------
    | Facebook App Secret
    |--------------------------------------------------------------------------
    |
    | Your Facebook application secret, which is used to verify
    | incoming requests from Facebook.
    |
    */
    'app_secret' => env('FACEBOOK_APP_SECRET'),

    /*
    |--------------------------------------------------------------------------
    | Facebook Verification
    |--------------------------------------------------------------------------
    |
    | Your Facebook verification token, used to validate the webhooks.
    |
    */
    'verification' => env('FACEBOOK_VERIFICATION'),

    /*
    |--------------------------------------------------------------------------
    | Facebook Start Button Payload
    |--------------------------------------------------------------------------
    |
    | The payload which is sent when the Get Started Button is clicked.
    |
    */
    'start_button_payload' => 'GET_STARTED_NOW',

    /*
    |--------------------------------------------------------------------------
    | Facebook Greeting Text
    |--------------------------------------------------------------------------
    |
    | Your Facebook Greeting Text which will be shown on your message start screen.
    |
    */
    'greeting_text' => [
        'greeting' => [
            [
                'locale' => 'default',
                'text' => 'Hello!',
            ],
            [
                'locale' => 'en_US',
                'text' => 'Timeless apparel for the masses.',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Facebook Persistent Menu
    |--------------------------------------------------------------------------
    |
    | Example items for your persistent Facebook menu.
    |
    */
    'persistent_menu' => [
        [
            'locale' => 'default',
            'composer_input_disabled' => 'false',
            'call_to_actions' => [
                [
                    'title' => '💌 Edit subscription',
                    'type' => 'postback',
                    'payload' => 'subscribe',
                ],
                [
                    'type' => 'web_url',
                    'title' => '📚 Book website ',
                    'url' => 'https://christoph-rumpel.com/build-chatbots-with-php',
                    'webview_height_ratio' => 'full',
                ],
                [
                    'type' => 'nested',
                    'title' => '🙈 Privacy',
                    'call_to_actions' => [
                        [
                            'type' => 'web_url',
                            'title' => 'Privacy Policy',
                            'url' => 'https://christoph-rumpel.com/policy-newsletterchatbot',
                            'webview_height_ratio' => 'full',
                        ],
                        [
                            'type' => 'postback',
                            'title' => 'Show your stored data',
                            'payload' => 'SHOW_USER_DATA',
                        ],
                        [
                            'type' => 'postback',
                            'title' => 'Delete your stored data',
                            'payload' => 'DELETE_USER_DATA',
                        ],
                    ]
                ],

            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Facebook Domain Whitelist
    |--------------------------------------------------------------------------
    |
    | In order to use domains you need to whitelist them
    |
    */
    'whitelisted_domains' => [
        'https://christoph-rumpel.com',
    ],
];
