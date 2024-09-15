<?php

declare(strict_types=1);

namespace App\Services\ExchangeRate\Dto;

final readonly class ExchangeRateItemDto
{
    public function __construct(private float $rate) {}

    public function getRate(): float
    {
        return $this->rate;
    }
}