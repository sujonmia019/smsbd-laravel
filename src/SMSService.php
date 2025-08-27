<?php

namespace Sujon\Smsbd;

use Sujon\Smsbd\Gateways\ArenaGateway;
use Sujon\Smsbd\Gateways\TwilloGateway;
use Sujon\Smsbd\Gateways\ElitbuzzGateway;
use Sujon\Smsbd\Gateways\GatewayInterface;

class SMSService {

    protected GatewayInterface $gateway;

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
            case 'twilio':
                $this->gateway = new TwilloGateway();
                break;
            default:
                throw new \Exception("SMS Gateway [$gateway] not supported.");
        }
    }

    public function send(string $to, string $message)
    {
        return $this->gateway->send($to, $message);
    }

}

