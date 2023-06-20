<?php

namespace NBP\Application;

class CurrencyRate
{

    public function __construct(
        public string $currency,
        public string $code,
        public float $mid,
    )
    {
    }
}