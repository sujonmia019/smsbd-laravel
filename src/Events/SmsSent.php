<?php

namespace SujonMia\Smsbd\Events;

class SmsSent {
    public function __construct(
        public string $to,
        public string $message,
        public $response
    ) {}
}