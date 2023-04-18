<?php
namespace Skinpay\Request;
interface RequestInterface{
    public function send(RequestInterface $request): array;

    public function getAction();

    public function getData();

    public function getMethod();
}
