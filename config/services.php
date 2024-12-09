<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

'paypal' => [
    'client_id' => env('AVYw8z70m2mThI4uMpAk6I2gPPi3VIZg56vD3rIpR-S7Wy35p8ebzJo1yEhTPjIpWUosKS04_UVQ58cH'),
    'secret' => env('EMZckxvZISUPNwerRF8zbvUJULFj2Mi_zIj0_Wr6RdDGfQE7CI5XpAsc6O8OJFYoHxro4r43OLKtN6TP'),
    'mode' => env('PAYPAL_MODE', 'sandbox'), 
],

'stripe' => [
    'key' => env('pk_test_51QTaumDchKdQnqQ3rQd7z45kKbckF9muDicvoH2vDFTw2C3vLpWFiq0lHMcsFXgvYgZyvBJ4rsf9fUKX7KTfYOly003vK2EZqq'),
    'secret' => env('sk_test_51QTaumDchKdQnqQ3cSfJu1WZOrUotmdfSscKqL8hdnjSfw8BTitZKVHXO6himr3GO0coiahbVm48BPpaEenbwvX600nnVwTOp9'),
],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
