<?php

namespace NBP\Application;

use PDO;

class FetchData
{

    public function __construct(private PDO $pdo)
    {
    }

    public function insertData()
    {
        $url = 'http://api.nbp.pl/api/exchangerates/tables/A';
        $json = file_get_contents($url);
        $data = json_decode($json, true);

        if (!empty($data) && is_array($data)) {
            $rates = $data[0]['rates'];

            foreach ($rates as $rate) {
                $currency = $rate['currency'];
                $code = $rate['code'];
                $mid = $rate['mid'];

                $query = "INSERT INTO currency (currency, code, mid) VALUES (?, ?, ?)";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$currency, $code, $mid]);
            }

            echo 'Dane zostały pobrane i zapisane w bazie danych.';
        } else {
            echo 'Nie udało się pobrać danych z API.';
        }
    }

    public function updateData()
    {
        $url = 'http://api.nbp.pl/api/exchangerates/tables/A';
        $json = file_get_contents($url);
        $data = json_decode($json, true);

        // Sprawdzenie, czy pobrano dane
        if (!empty($data) && is_array($data)) {
            // Pobranie informacji o kursach walut
            $rates = $data[0]['rates'];

            foreach ($rates as $rate) {
                $currency = $rate['currency'];
                $code = $rate['code'];
                $mid = $rate['mid'];

                $query = "UPDATE currency SET mid = ? WHERE code = ?";
                $stmt = $this->pdo->prepare($query);
                $stmt->execute([$mid, $code]);
            }
        }
    }

    public function isCurrencyTableEmpty()
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