<?php

return [
    'gateway' => env('SMS_GATEWAY', 'arena'),

    'gateways' => [
        'arena' => [
            'driver'    => \SujonMia\Smsbd\Gateways\ArenaGateway::class,
            'acode'     => env('ARENA_ACODE'),
            'api_key'   => env('ARENA_API_KEY'),
            'sender_id' => env('ARENA_SENDER_ID'),
            'url'       => env('ARENA_API_URL'),
        ],

        'elitbuzz' => [
            'driver'    => \SujonMia\Smsbd\Gateways\ElitbuzzGateway::class,
            'api_key'   => env('ELIT_API_KEY'),
            'type'      => env('ELIT_TYPE', 'text'),
            'sender_id' => env('ELIT_SENDER_ID'),
            'url'       => env('ELIT_API_URL'),
        ],

        'bulksmsbd' => [
            'driver'    => \SujonMia\Smsbd\Gateways\BulkSMSBDGateway::class,
            'api_key'   => env('BULK_SMSBD_KEY'),
            'sender_id' => env('BULK_SMSBD_SENDER_ID'),
            'url'       => env('BULK_SMSBD_URL'),
        ],

        'twilio' => [
            'driver'    => \SujonMia\Smsbd\Gateways\TwilloGateway::class,
            'sid'       => env('TWILIO_SMS_SID'),
            'token'     => env('TWILIO_SMS_TOKEN'),
            'sender_id' => env('TWILIO_SMS_SENDER'),
        ],

    ],

];
