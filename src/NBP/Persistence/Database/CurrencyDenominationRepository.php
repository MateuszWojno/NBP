<?php

namespace NBP\Persistence\Database;

use PDO;

class CurrencyDenominationRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function addCurrencyDenomination(string $startingCurrency, string $targetCurrency, string $amount, string $date): void
    {
        $statement = $this->pdo->prepare("INSERT INTO currencyDenomination (`startingCurrency`, `targetCurrency`, `amount`, `date`) VALUES (:startingCurrency, :targetCurrency, :amount, :date)");
        $statement->bindParam(':startingCurrency', $startingCurrency, PDO::PARAM_STR);
        $statement->bindParam(':targetCurrency', $targetCurrency, PDO::PARAM_STR);
        $statement->bindParam(':amount', $amount, PDO::PARAM_STR);
        $statement->bindParam(':date', $date, PDO::PARAM_STR);
        $statement->execute();
    }
}