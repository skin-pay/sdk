<?php

namespace Skinpay\Response;

class ShopBalance
{
    public function __construct(
        public float $deposit,
        public float $moneyDeposit,
        public float $skinWithdraw,
        public float $moneyWithdraw,
        public int $pushback_errors,
        public string $domain,
        public float $balance
    ) {

    }
}