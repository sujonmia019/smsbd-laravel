<?php

namespace Sujon\Smsbd\Gateways;

use Illuminate\Support\Facades\Http;

class ArenaGateway implements GatewayInterface{

    protected $aCode;
    protected $apiKey;
    protected $maskingName;
    protected $apiUrl;

    public function __construct()
    {
        $this->aCode       = config('laravel-sms.arena.acode');
        $this->apiKey      = config('laravel-sms.arena.api_key');
        $this->maskingName = config('laravel-sms.arena.masking');
        $this->apiUrl      = config('laravel-sms.arena.url');
    }

    public function send(string $to, string $message)
    {
        $headers = [
            'Content-Type'     => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ];

        $body = [
            "auth" => [
                "acode"  => $this->aCode,
                "apiKey" => $this->apiKey
            ],
            "smsInfo" => [
                "requestID"       => uniqid(),
                "message"         => $message,
                "is_unicode"      => 0,
                "masking"         => "$this->maskingName",
                "msisdn"          => "88" . $to,
                "transactionType" => "T",
                "contentID"       => ""
            ]
        ];

        $response = Http::withHeaders($headers)
            ->post("$this->apiUrl", $body);

        if ($response->successful()) {
            return $response->json();
        } else {
            return [
                'error'   => true,
                'status'  => $response->status(),
                'message' => $response->body()
            ];
        }
    }

}
