<?php

namespace SujonMia\Smsbd\Gateways;

use Illuminate\Support\Facades\Http;

class TwilloGateway implements GatewayInterface {

    protected $sid;
    protected $token;
    protected $senderId;

    public function __construct()
    {
        $this->sid      = config('laravel-sms.gateways.twilio.sid');
        $this->token    = config('laravel-sms.gateways.twilio.token');
        $this->senderId = config('laravel-sms.gateways.twilio.sender_id');
    }

    public function send($to, $message){
        if (empty($this->sid) || empty($this->token) || empty($this->senderId)) {
            throw new \Exception("Twilio credentials or sender ID are missing.");
        }

        $response = Http::withBasicAuth($this->sid, $this->token)
            ->asForm()
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$this->sid}/Messages.json", [
                'From' => $this->senderId,
                'To'   => $to,
                'Body' => $message,
            ]);

        if (!$response->successful()) {
            return [
                'error'   => true,
                'status'  => $response->status(),
                'message' => $response->body()
            ];

        }

        return $response->json();
    }

}
