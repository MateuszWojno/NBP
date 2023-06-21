<?php

namespace NBP\Persistence\Database;

use NBP\Application\CurrencyDenominationData;
use PDO;

class CurrencyDenominationReadRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function fetchCurrencyRates(): array
    {
        $query = $this->pdo->prepare("SELECT * FROM currencyDenomination");
        $query->execute();

        $allCurrencydenomination = [];

        while ($row = $query->fetch()) {
            $allCurrencydenomination[] = new CurrencyDenominationData(
                $row['startingCurrency'],
                $row['targetCurrency'],
                $row['amount'],
                $row['date']);
        }
        return $allCurrencydenomination;
    }
}