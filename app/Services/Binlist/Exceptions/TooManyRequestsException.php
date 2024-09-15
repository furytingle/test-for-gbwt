<?php

declare(strict_types=1);

namespace App\Services\Binlist\Exceptions;

use Exception;

class TooManyRequestsException extends Exception
{
    protected $message = 'Too many requests';
}