<?php

namespace Skinpay\Tools;

class Sign
{
    public static function sign(array $data, string $privateKey): string
    {
        ksort($data);
        $m = [];
        foreach ($data as $key => $val) {
            $m[] = "{$key}:{$val}";
        }
        $strData = implode(';', $m) . ";";
        return hash_hmac('sha1', $strData, $privateKey);
    }
}