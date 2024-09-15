<?php

declare(strict_types=1);

namespace app\Dto;
final readonly class FixedAmountDto
{
    public function __construct(private float $amount)
    {
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getFormatted(): string
    {
        return number_format($this->amount, 2, '.', '');
    }
}