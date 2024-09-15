<?php

declare(strict_types=1);

namespace App\Services\Binlist;

use App\Services\Binlist\Dto\BinlistItemBankDto;
use App\Services\Binlist\Dto\BinlistItemCountryDto;
use App\Services\Binlist\Dto\BinlistItemDto;
use App\Services\Binlist\Exceptions\RequestException;
use App\Services\Binlist\Exceptions\TooManyRequestsException;

class BinlistService implements BinlistServiceInterface
{
    protected const string API_BASE_URL = 'https://lookup.binlist.net/';

    protected const int TOO_MANY_REQUESTS_CODE = 429;

    public function getItemById(string $id): ?BinlistItemDto
    {
        $data = $this->sendRequest($id);

        if (empty($data) || empty($data['country']) || empty($data['bank'])) {
            return null;
        }

        $countryData = $data['country'];
        $country = new BinlistItemCountryDto(
            (int)$countryData['numeric'],
            $countryData['alpha2'],
            $countryData['name'],
            $countryData['currency'],
            (float) $countryData['latitude'],
            (float) $countryData['longitude']
        );

        $bankData = $data['bank'];
        $bank = new BinlistItemBankDto($bankData['name']);

        return new BinlistItemDto($data['scheme'], $data['type'], $data['brand'], $country, $bank);
    }

    protected function sendRequest(string $id): array
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::API_BASE_URL . $id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        $responseCode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

        if ($responseCode === self::TOO_MANY_REQUESTS_CODE) {
            throw new TooManyRequestsException();
        }

        if ($response === false) {
            throw new RequestException(curl_error($ch));
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}