<?php

namespace SujonMia\Smsbd\Gateways;

use Illuminate\Support\Facades\Http;

class ArenaGateway implements GatewayInterface
{  
    protected $aCode;
    protected $apiKey;
    protected $senderId;
    protected $apiUrl;

    public function __construct()
    {
        $this->aCode    = config('laravel-sms.gateways.arena.acode');
        $this->apiKey   = config('laravel-sms.gateways.arena.api_key');
        $this->senderId = config('laravel-sms.gateways.arena.sender_id');
        $this->apiUrl   = config('laravel-sms.gateways.arena.url');
    }

    /**
     * Override sender dynamically
     */
    public function sender(string $sender): self
    {
        $this->senderId = $sender;
        return $this;
    }

    public function send(string $to, string $message)
    {
        if (empty($this->aCode) || empty($this->apiKey) || empty($this->senderId) || empty($this->apiUrl)) {
            throw new \Exception("Arena credentials or sender ID are missing.");
        }

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
                "masking"         => $this->senderId,
                "msisdn"          => ltrim($to, '+'), // avoid double 88
                "transactionType" => "T",
                "contentID"       => ""
            ]
        ];

        $response = Http::withHeaders($headers)
            ->post($this->apiUrl, $body);

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


