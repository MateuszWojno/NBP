<?php

require_once 'src/autoload.php';

use NBP\Application\CurrencyDenomination;
use NBP\Http\Request\CurrencyDenominationRequest;
use NBP\Persistence\ConnectionString;
use NBP\Persistence\CredentialsFile;
use NBP\Persistence\Database\CurrencyDenominationRepository;
use NBP\Persistence\Database\CurrencyRateReadRepository;
use NBP\View\Validation;
use NBP\View\Views\CurrencyDenominationView;

$string = new ConnectionString(new CredentialsFile("connection.txt"));
$pdo = $string->getPdo();

function getView(CurrencyRateReadRepository $currencyRateReadRepository, CurrencyDenominationRequest $request, CurrencyDenomination $currencyDenomination, CurrencyDenominationRepository $denominationRepository)
{

    if (!$request->isConvert()) {
        return new CurrencyDenominationView($currencyRateReadRepository->fetchCurrencyRates(), null, Validation::success());
    }

    $startingCurrency = $request->startingCurrency();
    list($midStarting, $currencyStarting) = explode('|', $startingCurrency);
    $targetCurrency = $request->targetCurrency();
    list($midTarget, $currencyTarget) = explode('|', $targetCurrency);

    if ($request->amount() === '') {
        return new CurrencyDenominationView($currencyRateReadRepository->fetchCurrencyRates(), null, Validation::failure('amount', 'Empty field'));
    }

    if (!is_numeric($request->amount())) {
        return new CurrencyDenominationView($currencyRateReadRepository->fetchCurrencyRates(), null, Validation::failure('amount', 'Provide amount'));
    }
    $denominationRepository->addCurrencyDenomination($currencyStarting, $currencyTarget, $request->amount(), date('y-m-d'));
    return new CurrencyDenominationView($currencyRateReadRepository->fetchCurrencyRates(), $currencyDenomination->convert($midStarting, $midTarget, $request->amount()), Validation::success());
}

$getView = getView(new CurrencyRateReadRepository($pdo), new CurrencyDenominationRequest($_POST), new CurrencyDenomination(), new CurrencyDenominationRepository($pdo));
$getView->render();


