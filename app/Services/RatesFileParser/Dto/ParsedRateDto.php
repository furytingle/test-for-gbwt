<?php

declare(strict_types=1);

namespace app\Services\RatesFileParser\Dto;

final readonly class ParsedRateDto
{
    public function __construct(
        private string $binlistId,
        private float  $amount,
        private string $currency
    )
    {}

    public function getBinlistId(): string
    {
        return $this->binlistId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }


}