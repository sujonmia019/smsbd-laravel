<?php

namespace SujonMia\Smsbd;

use SujonMia\Smsbd\Models\SmsLog;
use SujonMia\Smsbd\Events\SmsSent;
use SujonMia\Smsbd\Events\SmsFailed;
use SujonMia\Smsbd\Gateways\GatewayInterface;

class SMSService {

    protected GatewayInterface $gateway;
    protected ?string $customSender = null;

    public function __construct()
    {
        $this->gateway = $this->resolveGateway(config('laravel-sms.gateway'));
    }

    protected function resolveGateway(string $name): GatewayInterface
    {
        $gateways = config('laravel-sms.gateways');

        if (!isset($gateways[$name]['driver'])) {
            throw new \Exception("SMS Gateway [$name] not configured.");
        }

        $class = $gateways[$name]['driver'];
        return new $class($gateways[$name] ?? []);
    }

    public function via(string $gateway): self
    {
        $this->gateway = $this->resolveGateway($gateway);
        return $this;
    }

    public function sender(string $sender): self
    {
        $this->customSender = $sender;
        return $this;
    }

    public function send(string $to, string $message)
    {
        $senderId = $this->customSender;

        if (!empty($senderId) && method_exists($this->gateway, 'sender')) {
            $this->gateway->sender($senderId);
        }
  
        try {
            $response = $this->gateway->send($to, $message);

            SmsLog::create([
                'to'       => $to,
                'message'  => $message,
                'provider' => get_class($this->gateway),
                'status'   => 'sent',
                'response' => json_encode($response),
            ]);

            event(new SmsSent($to, $message, $response));

            return $response;
        } catch (\Exception $e) {

            SmsLog::create([
                'to'       => $to,
                'message'  => $message,
                'provider' => get_class($this->gateway),
                'status'   => 'failed',
                'response' => $e->getMessage(),
            ]);

            event(new SmsFailed($to, $message, $e));

            throw $e;
        }
    }

}

