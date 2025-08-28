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
        $this->apiKey   = config('laravel-sms.elitbuzz.api_key');
        $this->type     = config('laravel-sms.elitbuzz.type');
        $this->senderId = config('laravel-sms.elitbuzz.sender_id');
        $this->apiUrl   = config('laravel-sms.elitbuzz.url');
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
