<?php

namespace SujonMia\Smsbd\Gateways;

use Illuminate\Support\Facades\Http;

class BulkSMSBDGateway implements GatewayInterface{

    protected $apiKey;
    protected $senderId;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey      = config('laravel-sms.bulksmsbd.api_key');
        $this->senderId    = config('laravel-sms.bulksmsbd.sender_id');
        $this->apiUrl      = config('laravel-sms.bulksmsbd.url');
    }

    /**
     * Set sender ID dynamically (overrides config sender ID)
     */
    public function sender(string $sender): self
    {
        $this->senderId = $sender;
        return $this;
    }

    public function send(string $to, string $message)
    {
        $param = [
            'api_key'  => $this->apiKey,
            'number'   => $to,
            'senderid' => $this->senderId,
            'message'  => $message
        ];

        $response = Http::asForm()->post("$this->apiUrl", $param);

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
