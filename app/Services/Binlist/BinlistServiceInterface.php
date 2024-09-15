<?php

declare(strict_types=1);

namespace App\Services\Binlist;

use App\Services\Binlist\Dto\BinlistItemDto;

interface BinlistServiceInterface
{
    public function getItemById(string $id): ?BinlistItemDto;
}