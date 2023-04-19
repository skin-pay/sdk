<?php

namespace Skinpay\Request;
/**
 * Class Request
 */
final class Request implements RequestInterface{
    public function __construct(public string $action, public array $data = [], public string $method = 'GET') {

    }

    public function send(RequestInterface $request): array {
        return [];
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}
