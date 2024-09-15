<?php

declare(strict_types=1);

namespace app;

use app\Dto\FixedAmountDto;
use App\Helpers\CountriesHelper;
use App\Helpers\CurrencyHelper;
use App\Services\Binlist\BinlistService;
use App\Services\Binlist\BinlistServiceInterface;
use App\Services\ExchangeRate\Exceptions\CurrencyIsNotSupportedException;
use App\Services\ExchangeRate\ExchangeRateService;
use App\Services\ExchangeRate\ExchangeRateServiceInterface;
use app\Services\RatesFileParser\RatesFileParser;
use app\Services\RatesFileParser\RatesFileParserInterface;

class Main
{
    protected RatesFileParserInterface $fileParser;

    protected BinlistServiceInterface $binlistService;

    protected ExchangeRateServiceInterface $exchangeRateService;

    public function __construct()
    {
        $this->fileParser = new RatesFileParser();
        $this->binlistService = new BinlistService();
        $this->exchangeRateService = new ExchangeRateService();
    }

    /**
     * @param string $filePath
     * @return FixedAmountDto[]
     * @throws CurrencyIsNotSupportedException
     * @throws Services\RatesFileParser\Exceptions\FileDoesntExistException
     * @throws \App\Services\ExchangeRate\Exceptions\MissingCurrencyRate
     */
    public function run(string $filePath): array
    {
        $rows = $this->fileParser->parse($filePath);

        $output = [];

        foreach ($rows as $row) {
            $binlistItem = $this->binlistService->getItemById($row->getBinlistId());

            if (is_null($binlistItem)) {
                continue;
            }

            if (!CurrencyHelper::isCurrencySupported($row->getCurrency())) {
                throw new CurrencyIsNotSupportedException();
            }

            $exchangeRate = $this->exchangeRateService->getRateByCurrency($row->getCurrency());

            $amount = 0;
            $multiplier = CountriesHelper::isEu($binlistItem->getCountry()->getAlpha2()) ? 0.01 : 0.02;

            //Not sure if rate can be 0
            if ($row->getCurrency() === CurrencyHelper::EUR || 0 == $exchangeRate->getRate()) {
                $amount = $row->getAmount();
            }

            if ($row->getCurrency() !== CurrencyHelper::EUR || 0 < $exchangeRate->getRate()) {
                $amount = $row->getAmount() / $exchangeRate->getRate();
            }

            $amount *= $multiplier;
            $fixedAmount = new FixedAmountDto($amount);

            $output[] = $fixedAmount;

            echo $amount . PHP_EOL;
        }

        return $output;
    }
}