<?php

return [
    'gateway' => env('SMS_GATEWAY', 'arena'),

    'arena' => [
        'acode'     => env('ARENA_ACODE'),
        'api_key'   => env('SMS_API_KEY'),
        'sender_id' => env('SMS_SENDER_ID'),
        'url'       => env('SMS_API_URL')
    ],

    'elitbuzz' => [
        'api_key'   => env('SMS_API_KEY'),
        'type'      => env('ELIT_TYPE'),
        'sender_id' => env('SMS_SENDER_ID'),
        'url'       => env('SMS_API_URL')
    ],

    'bulksmsbd' => [
        'api_key'   => env('SMS_API_KEY'),
        'sender_id' => env('SMS_SENDER_ID'),
        'url'       => env('SMS_API_URL')
    ],

    'twilio' => [
        'sid'       => env('TWILIO_SMS_SID'),
        'token'     => env('TWILIO_SMS_TOKEN'),
        'sender_id' => env('SMS_SENDER_ID'),
    ],
];
