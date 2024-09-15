<?php

declare(strict_types=1);

namespace App\Services\ExchangeRate;

use App\Services\ExchangeRate\Dto\ExchangeRateItemDto;

interface ExchangeRateServiceInterface
{
    public function getRateByCurrency(string $currencyCode): ExchangeRateItemDto;
}