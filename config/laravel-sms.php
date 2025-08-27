<?php

    return [
        'gateway' => env('SMS_GATEWAY', 'arena'),

        'arena' => [
            'acode'     => env('ARENA_ACODE'),
            'api_key'   => env('API_KEY'),
            'sender_id' => env('SENDER_ID'),
            'url'       => env('API_URL')
        ],

        'elitbuzz' => [
            'api_key'   => env('ELIT_API_KEY'),
            'type'      => env('ELIT_TYPE'),
            'sender_id' => env('SENDER_ID'),
            'url'       => env('API_URL')
        ],

        'twilio' => [
            'sid'       => env('TWILIO_SID'),
            'token'     => env('TWILIO_TOKEN'),
            'sender_id' => env('TWILIO_SENDER_ID'),
        ],

        'nexmo' => [
            'api_key'   => env('NEXMO_API_KEY'),
            'sender_id' => env('NEXMO_SENDER_ID'),
        ],
    ];
