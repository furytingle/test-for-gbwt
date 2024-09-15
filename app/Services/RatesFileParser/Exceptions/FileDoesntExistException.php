<?php

declare(strict_types=1);

namespace app\Services\RatesFileParser\Exceptions;

use Exception;

class FileDoesntExistException extends Exception
{
    protected $message = 'File does not exist';
}