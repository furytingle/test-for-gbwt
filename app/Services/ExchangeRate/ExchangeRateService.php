<?php

declare(strict_types=1);

namespace App\Services\ExchangeRate;

use Random\Randomizer;
use App\Helpers\CurrencyHelper;
use App\Services\ExchangeRate\Dto\ExchangeRateItemDto;
use App\Services\ExchangeRate\Exceptions\MissingCurrencyRate;
use App\Services\ExchangeRate\Exceptions\RequestException;

class ExchangeRateService implements ExchangeRateServiceInterface
{
    protected const string API_BASE_URL = 'https://api.exchangeratesapi.io/';

    //Since I get "You have not supplied an API Access Key. [Required format: access_key=YOUR_ACCESS_KEY]"
    //I made a test method and property for that
    protected bool $testMode = true;

    public function getRateByCurrency(string $currencyCode): ExchangeRateItemDto
    {
        $data = $this->testMode ? $this->getTestData() : $this->sendRequest();
        $rates = $data['rates'];

        if (!isset($rates[$currencyCode])) {
            throw new MissingCurrencyRate(sprintf('Currency %s has no data', $currencyCode));
        }

        return new ExchangeRateItemDto($rates[$currencyCode]);
    }

    protected function sendRequest(): array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::API_BASE_URL . 'latest');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new RequestException(curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response, true);
    }

    protected function getTestData(): array
    {
        $randomizer = new Randomizer();

        return [
            'rates' => [
                CurrencyHelper::EUR => $randomizer->getFloat(0.1, 2.0),
                CurrencyHelper::USD => $randomizer->getFloat(0.1, 2.5),
                CurrencyHelper::GBP => $randomizer->getFloat(0.1, 4.0),
                CurrencyHelper::JPY => $randomizer->getFloat(0.1, 10.0)
            ]
        ];
    }
}