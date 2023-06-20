<?php

namespace NBP\Persistence\Database;

use NBP\Application\CurrencyRate;
use PDO;

class CurrencyRateReadRepository
{

    public function __construct(private PDO $pdo)
    {
    }

    public function fetchCurrencyRates(): array
    {
        $query = $this->pdo->prepare("SELECT * FROM currency");
        $query->execute();

        $currencyRates = [];

        while ($row = $query->fetch()) {
            $currencyRates[] = new CurrencyRate(
                $row['currency'],
                $row['code'],
                $row['mid']);
        }
        return $currencyRates;
    }
}