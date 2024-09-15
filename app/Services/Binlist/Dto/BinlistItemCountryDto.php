<?php

declare(strict_types=1);

namespace App\Services\Binlist\Dto;

final readonly class BinlistItemCountryDto
{
    public function __construct(
        private int $numeric,
        private string $alpha2,
        private string $name,
        private string $currency,
        private float $latitude,
        private float $longitude
    ) {}

    public function getNumeric(): int
    {
        return $this->numeric;
    }

    public function getAlpha2(): string
    {
        return $this->alpha2;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }
}