<?php

namespace Skinpay\Sender;

class SenderResolver
{
    public function __construct(
        public string $publicKey,
        public string $privateKey,
        public array $config = []
    ) {}

    public function resolve(): Sender
    {

        return new Sender('https://skinpay.com/api/', $this->publicKey, $this->privateKey, $this->config);
    }
}
