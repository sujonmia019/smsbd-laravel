<?php

namespace SujonMia\Smsbd\Events;

class SmsFailed {
    public function __construct(
        public string $to,
        public string $message,
        public \Exception $exception
    ) {}
}
