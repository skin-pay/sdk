<?php
namespace Skinpay;
use Skinpay\Exception\RequestException;
use Skinpay\Request\Request;
use Skinpay\Response\Currency;
use Skinpay\Response\GetOrders;
use Skinpay\Response\OrderStatus;
use Skinpay\Response\ShopBalance;
use Skinpay\Sender\SenderResolver;
use Skinpay\Tools\Sign;

class API {

    private SenderResolver $sendResolver;
    private string $publicKey;
    private string $privateKey;

    /**
     * API constructor.
     * @param string $publicKey
     * @param string $privateKey
     * @param array $config
     */
    public function __construct(string $publicKey, string $privateKey, array $config=[])
    {
        $this->publicKey = $publicKey;
        $this->privateKey = $privateKey;
        $this->sendResolver = new SenderResolver($publicKey, $privateKey, $config);
    }


    /**
     * @param int $orderid
     * @param int|null $steamid64
     * @param string|null $t_token
     * @param string|null $lang
     * @param string|null $currency
     * @param float|null $currency_rate
     * @param float|null $min_amount
     * @return string
     */
    public function makeDepositUrl(int $orderid, ?int $steamid64 = null, ?string $t_token = null, ?string $lang = null, ?string $currency = null, ?float $currency_rate = null, ?float $min_amount = null): string
    {
        $data = [
            'key' => $this->publicKey,
            'orderid' => $orderid,
            'userid' => $steamid64
        ];
        if ($t_token) {
            $data['t_token'] = $t_token;
        }
        if ($lang) {
            $data['lang'] = $lang;
        }
        if ($currency) {
            $data['currency'] = $currency;
        }
        if ($currency_rate) {
            $data['currency_rate'] = $currency_rate;
        }
        if ($min_amount) {
            $data['min_amount'] = $min_amount;
        }
        $data['sign'] = Sign::sign($data, $this->privateKey);

        return 'https://skinpay.com/deposit?' . http_build_query($data);
    }

    /**
     * @param int $orderid
     * @return OrderStatus
     * @throws RequestException
     * @throws \JsonException
     */
    public function getOrderStatus(int $orderid): OrderStatus|array
    {
        $request = new Request('getOrderStatus', [
            'orderid' => $orderid
        ], 'POST');
        $res = $this->sendResolver->resolve()->send($request);
        return new OrderStatus(
            success: $res['success'],
            error: $res['error'] ?? null,
            status: $res['status'] ?? null,
            amount: $res['amount'] ?? null,
            amount_site: $res['amount_site'] ?? null,
            amount_currency: $res['amount_currency'] ?? null,
            amount_real: $res['amount_real'] ?? null,
            amount_currency_rate: $res['amount_currency_rate'] ?? null,
            amount_rur: $res['amount_rur'] ?? null,
            transaction_id: $res['transaction_id'] ?? null,
            order_id: $res['order_id'] ?? null
        );
    }

    /**
     * @param int $tsFrom
     * @param int $tsTo
     * @return GetOrders
     * @throws RequestException
     * @throws \JsonException
     */
    public function getOrders(int $tsFrom, int $tsTo): GetOrders
    {
        $request = new Request('getOrders', [
            'tsFrom' => $tsFrom,
            'tsTo' => $tsTo
        ], 'POST');
        $res = $this->sendResolver->resolve()->send($request);

        return new GetOrders(
            success: $res['success'],
            error: $res['error'] ?? null,
            deposits: $res['deposits'] ?? []
        );
    }

    /**
     * @return ShopBalance
     * @throws RequestException
     * @throws \JsonException
     */
    public function getShopBalance(): ShopBalance
    {
        $request = new Request('getShopBalance', []);
        $res = $this->sendResolver->resolve()->send($request);
        return new ShopBalance(
            deposit: $res['deposit'],
            moneyDeposit: $res['moneyDeposit'],
            skinWithdraw: $res['skinWithdraw'],
            moneyWithdraw: $res['moneyWithdraw'],
            pushback_errors: $res['pushback_errors'],
            domain: $res['domain'],
            balance: $res['balance']
        );
    }

    /**
     * @return Currency[]
     * @throws RequestException
     * @throws \JsonException
     */
    public function listAvailableCurrency() :array
    {
        $request = new Request('currency', []);
        $res = $this->sendResolver->resolve()->send($request);

        return array_map(static function ($row) {
            return new Currency(
                code: $row['code'],
                rate: $row['rate'],
                name: $row['name']
            );
        }, $res);
    }

}
