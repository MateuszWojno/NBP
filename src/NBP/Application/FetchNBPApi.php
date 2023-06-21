<?php

namespace NBP\Application;

use PDO;

class FetchNBPApi
{
    protected $baseUrl = 'http://api.nbp.pl/api/exchangerates/tables/A';

    public function __construct(private PDO $pdo)
    {
    }

    public function getDataFromAPI(): array
    {
        $json = file_get_contents($this->baseUrl);
        $data = json_decode($json, true);
        return $data;
    }

    public function insertData(array $data): void
    {
        $rates = $data[0]['rates'];

        foreach ($rates as $rate) {
            $currency = $rate['currency'];
            $code = $rate['code'];
            $mid = $rate['mid'];

            $query = "INSERT INTO currency (currency, code, mid) VALUES (:currency, :code, :mid)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam('currency', $currency, PDO::PARAM_STR);
            $stmt->bindParam('code', $code, PDO::PARAM_STR);
            $stmt->bindParam('mid', $mid, PDO::PARAM_STR);
            $stmt->execute();
        }
    }

    public function updateData(array $data): void
    {
        $rates = $data[0]['rates'];

        foreach ($rates as $rate) {
            $code = $rate['code'];
            $mid = $rate['mid'];

            $query = "UPDATE currency SET mid = :mid WHERE code = :code";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam('mid', $mid, PDO::PARAM_STR);
            $stmt->bindParam('code', $code, PDO::PARAM_STR);
            $stmt->execute();
        }
    }

    public function isCurrencyTableEmpty(): bool
    {
        $query = "SELECT COUNT(*) FROM currency";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $count = $stmt->fetchColumn();

        if ($count == 0) {
            return true;
        } else {
            return false;
        }
    }
}