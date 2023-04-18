<?php

namespace Skinpay\Response;

class Currency
{
    public function __construct(
        public string $code,
        public float $rate,
        public ?string $name,
    ) {}
}