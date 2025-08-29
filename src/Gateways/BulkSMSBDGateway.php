<?php

namespace SujonMia\Smsbd\Gateways;

use Illuminate\Support\Facades\Http;

class BulkSMSBDGateway implements GatewayInterface{

    protected $apiKey;
    protected $senderId;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey      = config('laravel-sms.gateways.bulksmsbd.api_key');
        $this->senderId    = config('laravel-sms.gateways.bulksmsbd.sender_id');
        $this->apiUrl      = config('laravel-sms.gateways.bulksmsbd.url');
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
        if (empty($this->apiKey) || empty($this->senderId) || empty($this->apiUrl)) {
            throw new \Exception("BulkSMSBD credentials or sender ID are missing.");
        }

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
