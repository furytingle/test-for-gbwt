<?php

declare(strict_types=1);

namespace App\Services\ExchangeRate\Exceptions;

use Exception;

class CurrencyIsNotSupportedException extends Exception
{
    protected $message = 'Currency is not supported.';
}