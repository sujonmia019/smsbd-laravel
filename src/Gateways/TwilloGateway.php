<?php

namespace SujonMia\Smsbd\Gateways;

use Illuminate\Support\Facades\Http;

class TwilloGateway implements GatewayInterface {

    protected $sid;
    protected $token;
    protected $senderId;

    public function __construct()
    {
        $this->sid      = config('laravel-sms.twilio.sid');
        $this->token    = config('laravel-sms.twilio.token');
        $this->senderId = config('laravel-sms.twilio.sender_id');
    }

    public function send($to, $message){
        $response = Http::withBasicAuth($this->sid, $this->token)
            ->asForm()
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$this->sid}/Messages.json", [
                'From' => $this->senderId,
                'To'   => $to,
                'Body' => $message,
            ]);

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
