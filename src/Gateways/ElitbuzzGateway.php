<?php

namespace SujonMia\Smsbd\Gateways;

use Illuminate\Support\Facades\Http;

class ElitbuzzGateway implements GatewayInterface{

    protected $apiKey;
    protected $type;
    protected $senderId;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey   = config('laravel-sms.gateways.elitbuzz.api_key');
        $this->type     = config('laravel-sms.gateways.elitbuzz.type');
        $this->senderId = config('laravel-sms.gateways.elitbuzz.sender_id');
        $this->apiUrl   = config('laravel-sms.gateways.elitbuzz.url');
    }
        
    /**
     * Set sender ID dynamically (overrides config sender ID)
     */
    public function sender(string $sender): self
    {
        $this->senderId = $sender;
        return $this;
    }

    public function send($to, $message){
        if (empty($this->apiKey) || empty($this->type) || empty($this->senderId) || empty($this->apiUrl)) {
            throw new \Exception("Elitbuzz credentials or sender ID are missing.");
        }

        $param = [
            'api_key'   => $this->apiKey,
            'type'      => $this->type,
            'contacts'  => $to,
            'senderid'  => $this->senderId,
            'msg'       => $message
        ];

        $response = Http::asForm()->post($this->apiUrl, $param);

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
