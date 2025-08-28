<?php

namespace SujonMia\Smsbd;

use SujonMia\Smsbd\Gateways\ArenaGateway;
use SujonMia\Smsbd\Gateways\BulkSMSBDGateway;
use SujonMia\Smsbd\Gateways\TwilloGateway;
use SujonMia\Smsbd\Gateways\ElitbuzzGateway;
use SujonMia\Smsbd\Gateways\GatewayInterface;

class SMSService {

    protected GatewayInterface $gateway;
    protected ?string $customSender = null;

    public function __construct()
    {
        $gateway = config('laravel-sms.gateway');

        switch (strtolower($gateway)) {
            case 'arena':
                $this->gateway = new ArenaGateway();
                break;
            case 'elitbuzz':
                $this->gateway = new ElitbuzzGateway();
                break;
            case 'bulksmsbd':
                $this->gateway = new BulkSMSBDGateway();
                break;
            case 'twilio':
                $this->gateway = new TwilloGateway();
                break;
            default:
                throw new \Exception("SMS Gateway [$gateway] not supported.");
        }
    }

    /**
     * Set sender ID dynamically if gateway supports it
     */
    public function sender(string $sender): self
    {
        $this->customSender = $sender;
        return $this;
    }

    public function send(string $to, string $message)
    {
        $senderId = $this->customSender ?? config('laravel-sms.' . config('laravel-sms.gateway') . '.sender_id');

        if (!empty($senderId) && method_exists($this->gateway, 'sender')) {
            $this->gateway->sender($senderId);
        }

        return $this->gateway->send($to, $message);
    }

}

