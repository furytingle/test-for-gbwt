<?php

declare(strict_types=1);

namespace app\Services\RatesFileParser;

use SplFileObject;
use RuntimeException;
use app\Services\RatesFileParser\Dto\ParsedRateDto;
use app\Services\RatesFileParser\Exceptions\FileDoesntExistException;

class RatesFileParser implements RatesFileParserInterface
{
    public function parse(string $path): array
    {
        try {
            $file = new SplFileObject($path);
        } catch (RuntimeException) {
            throw new FileDoesntExistException();
        }

        $rates = [];

        foreach ($file as $line) {
            $rate = json_decode($line, true);
            $rates[] = new ParsedRateDto($rate['bin'], (float)$rate['amount'], $rate['currency']);
        }

        return $rates;
    }
}