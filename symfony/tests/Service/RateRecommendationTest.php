<?php

namespace App\Tests\Service;

use App\Exception\RateNotFoundException;
use App\Service\Rate;
use App\Service\RateClientInterface;
use App\Service\RateProvider;
use App\Service\RateProviderInterface;
use App\Service\RateRecommendation;
use PHPUnit\Framework\TestCase;

class RateRecommendationTest extends TestCase
{
    public function testRecommendationServiceReturnFalse(): void
    {
        $baseCurrency = 'GBP';
        $destinationCurrency = 'EUR';
        $euroRate = 0.8478168716;
        $rateProvider = $this->createMock(RateProviderInterface::class);
        $mockedHistoricalRateResponse = [
            'rates' => [
                '2020-10-01' => ['EUR' => $euroRate],
                '2020-10-02' => ['EUR' => 0.8578168716],
                '2020-10-03' => ['EUR' => 0.8378168716]
            ],
            'base' => $baseCurrency
        ];

        $rateProvider->method('getHistoricalRates')->willReturn($mockedHistoricalRateResponse);

        $rateProvider = new RateRecommendation($rateProvider);
        $currentRate = new Rate($baseCurrency, $destinationCurrency, $euroRate);
        $this->assertFalse($rateProvider->isGoodRate($currentRate, $baseCurrency, $destinationCurrency));
    }

    public function testRecommendationServiceReturnTrue(): void
    {
        $baseCurrency = 'GBP';
        $destinationCurrency = 'EUR';
        $euroRate = 0.8478168716;
        $rateProvider = $this->createMock(RateProviderInterface::class);
        $mockedHistoricalRateResponse = [
            'rates' => [
                '2020-10-01' => ['EUR' => $euroRate],
                '2020-10-02' => ['EUR' => 0.8578168716],
                '2020-10-03' => ['EUR' => 0.8577168716]
            ],
            'base' => $baseCurrency
        ];

        $rateProvider->method('getHistoricalRates')->willReturn($mockedHistoricalRateResponse);

        $rateProvider = new RateRecommendation($rateProvider);
        $currentRate = new Rate($baseCurrency, $destinationCurrency, $euroRate);
        $this->assertTrue($rateProvider->isGoodRate($currentRate, $baseCurrency, $destinationCurrency));
    }
}
