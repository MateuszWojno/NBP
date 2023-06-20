<?php

require_once 'src/autoload.php';

use NBP\Persistence\ConnectionString;
use NBP\Persistence\CredentialsFile;
use NBP\Persistence\Database\CurrencyRateReadRepository;
use NBP\View\View;
use NBP\Http\Request\CurrencyDenominationRequest;

$string = new ConnectionString(new CredentialsFile("connection.txt"));
$pdo = $string->getPdo();

function getView(CurrencyRateReadRepository $currencyRateReadRepository, CurrencyDenominationRequest $request): View
{
    $currencyRates = $currencyRateReadRepository->fetchCurrencyRates();
    return new View('src/NBP/View/pages/currencyDenomination.phtml', [
        'currencyRates' => $currencyRates,
    ]);

}

$getView = getView(new CurrencyRateReadRepository($pdo), new CurrencyDenominationRequest($_POST));
$getView->render();


