<?php

namespace Skinpay\Sender;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Skinpay\Exception\RequestException;
use Skinpay\Request\RequestInterface;
use Skinpay\Tools\Sign;

class Sender{

    private Client $client;

    public function __construct(
        public string $url,
        public string $publicKey,
        public string $privateKey,
        public array $config = []
    ) {
        $this->client = $this->getClient();
    }

    private function getClient(): Client
    {
        $defaultConfig = [
            'base_uri' => $this->url,
        ];

        return new Client(array_merge($defaultConfig, $this->config));
    }

    /**
     * @throws RequestException
     * @throws \JsonException
     */
    public function send(RequestInterface $request):array
    {
        try {
            $qData = array_merge($request->getData(), ['key' => $this->publicKey]);
            $qData['sign'] = Sign::sign($qData, $this->privateKey);
            if ($request->getMethod() === 'GET') {
                $response = $this->client->get($request->getAction(), [
                    'query' => $qData,
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                ]);
            }elseif ($request->getMethod() === 'POST') {
                $response = $this->client->post($request->getAction(), [
                    'form_params' => $qData,
                    'headers' => [
                        'Accept' => 'application/json',
                    ],
                ]);
            }else{
                throw new RequestException('Invalid method', 0);
            }
        } catch (GuzzleException $e) {
            throw new RequestException("Request send error, {$request->getAction()}", $e->getCode(), $e);
        }

        $body = (string) $response->getBody();

        return json_decode($body, true, 512, JSON_THROW_ON_ERROR);
    }
}
