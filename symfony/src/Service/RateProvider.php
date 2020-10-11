<?php

namespace App\Service;

use App\Exception\RateNotFoundException;

class RateProvider implements RateProviderInterface
{
    /** @var ExchangeRateClient */
    private $client;

    public function __construct(RateClientInterface $client)
    {
        $this->client = $client;
    }

    public function retrieveRate(string $baseCurrency, string $destinationCurrency): Rate
    {
        $response = $this->client->get('latest?base=' . $baseCurrency);
        if (!isset($response['rates'][$destinationCurrency])) {
            throw new RateNotFoundException();
        }

        return new Rate($baseCurrency, $destinationCurrency, $response['rates'][$destinationCurrency]);
    }

    public function getHistoricalRates(
        string $baseCurrency,
        string $destinationCurrency,
        \DateTime $startDate,
        \DateTime $endDate
    ): array {
        $uri = sprintf(
            "history?start_at=%s&end_at=%s&symbols=%s&base=%s",
            $startDate->format('Y-m-d'),
            $endDate->format('Y-m-d'),
            $destinationCurrency,
            $baseCurrency
        );

        return $this->client->get($uri);
    }
}
