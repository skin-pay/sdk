<?php

namespace Skinpay\Response\GetOrders;

class Order
{
    public function __construct(
        public string $status,
        public int $amount,
        public int $amount_site,
        public string $amount_currency,
        public int $amount_real,
        public int $amount_currency_rate,
        public int $amount_rur,
        public int $transaction_id,
        public string $order_id,
        public string $ts_create,
        public string $ts_offer
    ) { }
}