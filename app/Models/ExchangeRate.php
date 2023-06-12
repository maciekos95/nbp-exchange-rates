<?php

namespace App\Models;

use App\Services\DbConnection;
use App\Services\Lang;
use Exception;

class ExchangeRate
{
    /**
     * URL of the NBP API.
     */
    const API_URL = 'http://api.nbp.pl/api/exchangerates/tables/';

    /**
     * @var string The currency code.
     */
    public $currencyCode;

    /**
     * @var string The currency name.
     */
    public $currencyName;

    /**
     * @var float The exchange rate.
     */
    public $exchangeRate;

    /**
     * ExchangeRate constructor.
     * @param string $currencyCode The currency code.
     * @param string $currencyName The currency name.
     * @param float $exchangeRate The exchange rate.
     */
    public function __construct(string $currencyCode, string $currencyName, float $exchangeRate)
    {
        $this->currencyCode = $currencyCode;
        $this->currencyName = $currencyName;
        $this->exchangeRate = $exchangeRate;
    }

    /**
     * Get the exchange rate for the specified currency code.
     * @param string $currencyCode The currency code.
     * @return ExchangeRate|null The ExchangeRate object if available, null otherwise.
     */
    public static function getExchangeRate(string $currencyCode): self | null
    {
        $query = "SELECT * FROM exchange_rates WHERE currency_code = ? LIMIT 1";
        $params = [$currencyCode];
        $dbConnection = new DbConnection($query, $params);
        $data = $dbConnection->execute();

        if ($data) {
            return new self($data[0]['currency_code'], $data[0]['currency_name'], $data[0]['exchange_rate']);
        }

        return null;
    }

    /**
     * Get all exchange rates from the database.
     * @return array|null An array of ExchangeRate objects if available, null otherwise.
     */
    public static function getAllExchangeRates(): array | null
    {
        $query = "SELECT * FROM exchange_rates";
        $dbConnection = new DbConnection($query);
        $data = $dbConnection->execute();

        if ($data) {
            foreach ($data as $rate) {
                $exchangeRates[] = new self($rate['currency_code'], $rate['currency_name'], $rate['exchange_rate']);
            }

            return $exchangeRates;
        }

        return null;
    }

    /**
     * Fetch exchange rates from the NBP API.
     * @return array An array of ExchangeRate objects.
     * @throws Exception If there is an error fetching data from the API.
     */
    public static function fetchExchangeRates(): array
    {
        $responseA = file_get_contents(self::API_URL . 'a');
        $responseB = file_get_contents(self::API_URL . 'b');

        if (!$responseA && !$responseB) {
            throw new Exception(Lang::get('error_fetching_data') . ':<br>' . Lang::get('source_files_unavailable'));
        }

        $tableA = [];
        $tableB = [];

        if ($responseA) {
            $tableA = json_decode($responseA, true);

            if (!is_array($tableA) || !key_exists('rates', $tableA[0]))
            {
                $tableA = [];
            }
        }

        if ($responseB) {
            $tableB = json_decode($responseB, true);

            if (!is_array($tableB) || !key_exists('rates', $tableB[0]))
            {
                $tableB = [];
            }
        }

        if (empty($tableA) && empty($tableB)) {
            throw new Exception(Lang::get('error_fetching_data') . ':<br>' . Lang::get('source_files_invalid'));
        }

        $data = array_merge($tableA[0]['rates'], $tableB[0]['rates']);

        foreach ($data as $rate) {
            if (key_exists('code', $rate) && key_exists('currency', $rate) && key_exists('mid', $rate)) {
                $exchangeRates[] = new self($rate['code'], $rate['currency'], $rate['mid']);
            }
        }

        return $exchangeRates;
    }

    /**
     * Save or update fetched exchange rates to the database.
     * @param array $exchangeRates An array of ExchangeRate objects.
     */
    public static function saveExchangeRates(array $exchangeRates): void
    {
        $dbConnection = new DbConnection;

        foreach ($exchangeRates as $rate) {
            $dbConnection->query = "SELECT * FROM exchange_rates WHERE currency_code = ? LIMIT 1";
            $dbConnection->params = [$rate->currencyCode];
            $data = $dbConnection->execute();

            if ($data) {
                $dbConnection->query = "UPDATE exchange_rates SET exchange_rate = ? WHERE currency_code = ?";
                $dbConnection->params = [$rate->exchangeRate, $rate->currencyCode];
                $dbConnection->execute();
            } else {
                $dbConnection->query = "INSERT INTO exchange_rates (currency_code, currency_name, exchange_rate) VALUES (?, ?, ?)";
                $dbConnection->params = [$rate->currencyCode, $rate->currencyName, $rate->exchangeRate];
                $dbConnection->execute();
            }
        }
    }
}
