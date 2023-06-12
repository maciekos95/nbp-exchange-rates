<?php

namespace App\Models;

use App\Services\DbConnection;
use App\Services\Lang;
use App\Models\ExchangeRate;
use Exception;

class ConversionResult
{
    /**
     * @var string The source currency code.
     */
    public $sourceCurrency;

    /**
     * @var string The target currency code.
     */
    public $targetCurrency;

    /**
     * @var float The amount to convert.
     */
    public $amount;

    /**
     * @var float The converted amount.
     */
    public $convertedAmount;

    /**
     * ConversionResult constructor.
     * @param string $sourceCurrency The source currency code.
     * @param string $targetCurrency The target currency code.
     * @param float $amount The amount to convert.
     * @param float $convertedAmount The converted amount.
     */
    public function __construct(string $sourceCurrency, string $targetCurrency, float $amount, float $convertedAmount = 0)
    {
        $this->sourceCurrency = $sourceCurrency;
        $this->targetCurrency = $targetCurrency;
        $this->amount = $amount;
        $this->convertedAmount = $convertedAmount;
    }

    /**
     * Get the specified number of latest conversion results.
     * @param int $limit The maximum number of results to retrieve.
     * @return array|null An array of ConversionResult objects if available, null otherwise.
     */
    public static function getLatestConversionResults(int $limit = 20): array | null
    {
        $query = "SELECT * FROM conversion_results ORDER BY id DESC LIMIT ?";
        $params = [$limit];
        $dbConnection = new DbConnection($query, $params);
        $data = $dbConnection->execute();

        if ($data) {
            foreach ($data as $result) {
                $conversionResults[] = new self($result['source_currency'], $result['target_currency'], $result['amount'], $result['converted_amount']);
            }

            return $conversionResults;
        }

        return null;
    }

    /**
     * Perform the currency conversion.
     * @throws Exception If there is an error during the conversion.
     */
    public function convertCurrency(): void
    {
        $sourceRate = ExchangeRate::getExchangeRate($this->sourceCurrency);
        $targetRate = ExchangeRate::getExchangeRate($this->targetCurrency);

        if (!$sourceRate && $this->sourceCurrency != 'PLN') {
            throw new Exception(Lang::get('no_data_for_source'));
        }

        if (!$targetRate && $this->targetCurrency != 'PLN') {
            throw new Exception(Lang::get('no_data_for_target'));
        }

        if ($this->sourceCurrency == $this->targetCurrency) {
            throw new Exception(Lang::get('same_source_and_target'));
        }
        
        if ($this->sourceCurrency == 'PLN') {
            $convertedAmount = $this->amount / $targetRate->exchangeRate;
        } elseif ($this->targetCurrency == 'PLN') {
            $convertedAmount = $this->amount * $sourceRate->exchangeRate;
        } else {
            $convertedAmount = ($this->amount * $sourceRate->exchangeRate) / $targetRate->exchangeRate;
        }

        $this->convertedAmount = round($convertedAmount, 2);
    }

    /**
     * Save the currency conversion result to the database.
     */
    public function save(): void
    {
        $query = "INSERT INTO conversion_results (source_currency, target_currency, amount, converted_amount) VALUES (?, ?, ?, ?)";
        $params = [$this->sourceCurrency, $this->targetCurrency, $this->amount, $this->convertedAmount];
        $dbConnection = new DbConnection($query, $params);
        $dbConnection->execute();
    }
}
