<?php

namespace NBP\Application;

class CurrencyDenomination
{

    public function convert(string $startingCurrency, string $targetCurrency, string $amount): string
    {
        return $amount * ($startingCurrency / $targetCurrency);
    }
}