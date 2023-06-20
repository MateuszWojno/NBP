<?php

namespace NBP\Http\Request;

class CurrencyDenominationRequest
{
    private array $postAttributes;

    public function __construct(array $postAttributes)
    {
        $this->postAttributes = $postAttributes;
    }

    public function startingCurrency(): string
    {
        return $this->postAttributes['startingCurrency'];
    }

    public function targetCurrency(): string
    {
        return $this->postAttributes['targetCurrency'];
    }

    public function isConvert(): bool
    {
        return isset($this->postAttributes['convert']);
    }
}