<?php

namespace Skinpay\Response;

class OrderStatus
{
    public function __construct(
        public bool $success,
        public string $error,
        public ?string $status,
        public ?int $amount,
        public ?int $amount_site,
        public ?string $amount_currency,
        public ?int $amount_real,
        public ?float $amount_currency_rate,
        public ?int $amount_rur,
        public ?int $transaction_id,
        public ?int $order_id
    ) {}
}