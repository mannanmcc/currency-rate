<?php

namespace App\Service;

interface RateProviderInterface
{
    public function retrieveRate(string $baseCurrency, string $destinationCurrency): Rate;

    public function getHistoricalRates(
        string $baseCurrency,
        string $destinationCurrency,
        \DateTime $start,
        \DateTime $endDate
    ): array;
}
