<?php

namespace App\Controllers;

use App\Services\Lang;
use App\Services\View;
use App\Models\ExchangeRate;
use Exception;

class ExchangeRatesController
{
    /**
     * Display the current exchange rates page.
     */
    public function displayExchangeRates(): void
    {
        $errorMessages = [];

        try {
            $exchangeRatesFromApi = ExchangeRate::fetchExchangeRates();
            ExchangeRate::saveExchangeRates($exchangeRatesFromApi);
        } catch (Exception $e) {
            $errorMessages[] = $e->getMessage();
        }

        $exchangeRatesFromDb = ExchangeRate::getAllExchangeRates();

        if (!$exchangeRatesFromDb) {
            $errorMessages[] = Lang::get('no_exchange_rates_found');

            View::render(null, Lang::get('exchange_rates_title'), [
                'errorMessages' => $errorMessages,
            ]);
        } else {
            View::render('exchange_rates', Lang::get('exchange_rates_title'), [
                'errorMessages' => $errorMessages,
                'exchangeRates' => $exchangeRatesFromDb,
            ]);
        }
    }
}
