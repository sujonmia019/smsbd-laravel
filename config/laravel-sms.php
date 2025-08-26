<?php

    return [
        'gateway' => env('SMS_GATEWAY', 'twilio'),

        'arena' => [
            'acode'   => env('ARENA_ACODE', ''),
            'api_key' => env('ARENA_API_KEY', 'LaravelApp'),
            'masking' => env('MASKING_NAME'),
            'url'     => env('API_URL')
        ],

        'twilio' => [
            'api_key'   => env('TWILIO_API_KEY', ''),
            'sender_id' => env('TWILIO_SENDER_ID', 'LaravelApp'),
        ],

        'nexmo' => [
            'api_key'   => env('NEXMO_API_KEY', ''),
            'sender_id' => env('NEXMO_SENDER_ID', 'LaravelApp'),
        ],
    ];
