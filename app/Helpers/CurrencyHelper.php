<?php

declare(strict_types=1);

namespace App\Helpers;

class CurrencyHelper
{
    public const string EUR = 'EUR';
    public const string USD = 'USD';
    public const string JPY = 'JPY';
    public const string GBP = 'GBP';

    public const array SUPPORTED_CURRENCIES = [
        self::USD,
        self::EUR,
        self::JPY,
        self::GBP,
    ];

    public static function isCurrencySupported(string $currency): bool
    {
        return in_array($currency,self::SUPPORTED_CURRENCIES);
    }
}