<?php

namespace App\Controllers;

use App\Services\Lang;
use App\Services\View;
use App\Models\ExchangeRate;
use App\Models\ConversionResult;
use Exception;

class ConversionController
{
    /**
     * Display the currency conversion form.
     */
    public function displayConversionForm(): void
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
            $errorMessages[] = Lang::get('no_exchange_rates_found_conversion');

            exit(View::render(null, Lang::get('conversion_form_title'), [
                'errorMessages' => $errorMessages,
            ]));
        }

        $currencies[] = 'PLN';

        foreach ($exchangeRatesFromDb as $rate) {
            $currencies[] = $rate->currencyCode;
        }

        View::render('conversion_form', Lang::get('conversion_form_title'), [
            'errorMessages' => $errorMessages,
            'currencies' => $currencies,
        ]);
    }

    /**
     * Process the currency conversion form and display the result page.
     */
    public function processConversionForm(): void
    {
        if (!key_exists('source_currency', $_POST) || !key_exists('target_currency', $_POST) || !key_exists('amount', $_POST)) {
            exit(View::render(null, 'Error', [
                'errorMessages' => [Lang::get('form_processing_error') . ':<br>' . Lang::get('missing_data')],
            ]));
        }

        $conversionResult = new ConversionResult($_POST['source_currency'], $_POST['target_currency'], $_POST['amount']);

        try {
            $conversionResult->convertCurrency();
        } catch (Exception $e) {
            exit(View::render(null, 'Error', [
                'errorMessages' => [Lang::get('form_processing_error') . ':<br>' . $e->getMessage()],
            ]));
        }

        $conversionResult->save();

        View::render('conversion_form_result', Lang::get('conversion_form_result_title'), [
            'conversionResult' => $conversionResult,
        ]);
    }

    /**
     * Display the latest conversion results page.
     */
    public function displayLatestConversionResults(): void
    {
        $conversionResults = ConversionResult::getLatestConversionResults();

        if (!$conversionResults) {
            View::render(null, Lang::get('conversion_results_title'), [
                'errorMessages' => [Lang::get('no_conversion_results_found')],
            ]);
        } else {
            View::render('conversion_results', Lang::get('conversion_results_title'), [
                'conversionResults' => $conversionResults,
            ]);
        }
    }
}
