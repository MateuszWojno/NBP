<?php

namespace NBP\View\Views;

use NBP\View\Validation;
use NBP\View\View;

class CurrencyDenominationView extends View
{
    public function __construct(array $currencyRates, string|null $result, Validation $validation)
    {
        parent::__construct('src/NBP/View/pages/currencyDenomination.phtml', [
            'currencyRates' => $currencyRates,
            'result'        => $result,
            'validation'    => $validation,
        ]);
    }
}