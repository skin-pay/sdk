# Skinpay PHP SDK

* [Installation](#installation)
* [Usage](#usage)

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```sh
composer require skinpay/sdk
```

Or add

```
"skinpay/sdk": "*"
```

## Usage

```php
<?php

require_once __DIR__ . '/../vendor/autoload.php';

$publicKey = '';
$privateKey = '';
$steamid64 = 76561234234234234;

$skinpay = new \Skinpay\API($publicKey, $privateKey);
$url = $skinpay->makeDepositUrl(10, $steamid64);
```
