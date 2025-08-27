<?php

namespace Sujon\Smsbd\Gateways;

interface GatewayInterface {

    public function send(string $to, string $message);
    
}
