<?php

require_once 'src/autoload.php';

use NBP\Persistence\ConnectionString;
use NBP\Persistence\CredentialsFile;
use NBP\Persistence\Database\CurrencyDenominationReadRepository;
use NBP\View\View;

$string = new ConnectionString(new CredentialsFile("connection.txt"));
$pdo = $string->getPdo();

function getView(CurrencyDenominationReadRepository $denominationReadRepository): View
{

    $currencyRatesDenominations = $denominationReadRepository->fetchCurrencyRates();
    return new View('src/NBP/View/pages/currencyConversionList.phtml', [
        'currencyRatesDenominations' => $currencyRatesDenominations,
    ]);

}

$getView = getView(new CurrencyDenominationReadRepository($pdo));
$getView->render();