<?php

require_once __DIR__ . '/../vendor/autoload.php';

$publicKey = '';
$privateKey = '';
$steamid64 = 76561234234234234;

$skinpay = new \Skinpay\API($publicKey, $privateKey);
$url = $skinpay->makeDepositUrl(10, $steamid64);
