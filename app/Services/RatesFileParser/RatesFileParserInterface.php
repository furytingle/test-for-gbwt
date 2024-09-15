<?php

declare(strict_types=1);

namespace app\Services\RatesFileParser;

use app\Services\RatesFileParser\Dto\ParsedRateDto;

interface RatesFileParserInterface
{
    /**
     * @param string $path
     * @return ParsedRateDto[]
     */
    public function parse(string $path): array;
}