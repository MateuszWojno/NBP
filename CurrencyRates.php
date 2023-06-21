<?php

require_once 'src/autoload.php';

use NBP\Application\FetchNBPApi;
use NBP\Persistence\ConnectionString;
use NBP\Persistence\CredentialsFile;
use NBP\Persistence\Database\CurrencyRateReadRepository;
use NBP\View\View;

$string = new ConnectionString(new CredentialsFile("connection.txt"));
$pdo = $string->getPdo();

function getView(FetchNBPApi $fetchData, CurrencyRateReadRepository $currencyRateReadRepository): View
{
    $apiData = $fetchData->getDataFromAPI();

    if ($fetchData->isCurrencyTableEmpty() === true) {
        $fetchData->insertData($apiData);
    } else {
        $fetchData->updateData($apiData);
    }
    $currencyRates = $currencyRateReadRepository->fetchCurrencyRates();
    return new View('src/NBP/View/pages/currencyRates.phtml', [
        'currencyRates' => $currencyRates,
    ]);

}

$getView = getView(new FetchNBPApi($pdo), new CurrencyRateReadRepository($pdo));
$getView->render();










//
//
//$dsn = 'mysql:host=localhost;dbname=messbox';
//$username = 'root';
//$password = 'root ';
//
//try {
//    // Połączenie z bazą danych
//    $db = new PDO($dsn, $username, $password);
//    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//
//    // Pobranie danych z API NBP
//    $apiUrl = 'http://api.nbp.pl/api/exchangerates/tables/A';
//    $response = file_get_contents($apiUrl);
//    $data = json_decode($response, true);
//dd($data);
//    // Przygotowanie danych do wstawienia
//    $tableData = $data[0]['rates'];
//    $values = [];
//    $params = [];
//
//    foreach ($tableData as $row) {
//        $values[] = "(:currency, :code, :mid)";
//        $params[] = [
//            ':currency' => $row['currency'],
//            ':code' => $row['code'],
//            ':mid' => $row['mid']
//        ];
//        dd($values);
//    }
//
//    // Zapytanie SQL do wstawienia danych
//    $sql = "INSERT INTO currency (currency, code, mid) VALUES " . implode(", ", $values);
//    $stmt = $db->prepare($sql);
//
//    // Wykonanie zapytania dla wszystkich parametrów naraz
//    foreach ($params as $paramSet) {
//        $stmt->execute($paramSet);
//    }
//
//    echo "Dane zostały pobrane i wstawione do bazy danych.";
//} catch (PDOException $e) {
//    echo "Wystąpił błąd: " . $e->getMessage();
//}

