<?php

namespace Skinpay\Response;

use Skinpay\Response\GetOrders\Order;

class GetOrders
{
    public function __construct(
        public bool $success,
        public ?string $error,
        public array $deposits
    ) {
        if ($this->deposits) {
            $this->deposits = array_map(fn($item) => new Order(
                status: $item['status'],
                amount: $item['amount'],
                amount_site: $item['amount_site'],
                amount_currency: $item['amount_currency'],
                amount_real: $item['amount_real'],
                amount_currency_rate: $item['amount_currency_rate'],
                amount_rur: $item['amount_rur'],
                transaction_id: $item['transaction_id'],
                order_id: $item['order_id'],
                ts_create: $item['ts_create'],
                ts_offer: $item['ts_offer']
            ), $this->deposits);
        }
    }
}