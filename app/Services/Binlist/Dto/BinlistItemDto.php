<?php

declare(strict_types=1);

namespace App\Services\Binlist\Dto;

final readonly class BinlistItemDto
{
    public function __construct(
        private string                $scheme,
        private string                $type,
        private string                $brand,
        private BinlistItemCountryDto $country,
        private BinlistItemBankDto    $bank
    )
    {
    }

    public function getScheme(): string
    {
        return $this->scheme;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function getCountry(): BinlistItemCountryDto
    {
        return $this->country;
    }

    public function getBank(): BinlistItemBankDto
    {
        return $this->bank;
    }
}