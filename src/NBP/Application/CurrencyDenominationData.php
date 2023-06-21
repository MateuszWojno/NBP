<?php

namespace NBP\Application;

class CurrencyDenominationData
{

    public function __construct(
        public string $startingCurrency,
        public string $targetCurrency,
        public string $amount,
        public string $date,
    )
    {
    }

}