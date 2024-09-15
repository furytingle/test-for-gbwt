<?php

declare(strict_types=1);

namespace App\Services\Binlist\Dto;

final readonly class BinlistItemBankDto
{
    public function __construct(private string $name) {}

    public function getName(): string
    {
        return $this->name;
    }
}