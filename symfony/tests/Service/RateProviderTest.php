<?php

namespace App\Tests\Service;

use App\Exception\CurrencyNotSupportedException;
use App\Exception\RateNotFoundException;
use App\Service\Rate;
use App\Service\RateClientInterface;
use App\Service\RateProvider;
use PHPUnit\Framework\TestCase;

class RateProviderTest extends TestCase
{
    public function testItCanProvideRate(): void
    {
        $baseCurrency = 'GBP';
        $destinationCurrency = 'EUR';
        $euroRate = 0.8478168716;
        $rateClient = $this->createMock(RateClientInterface::class);
        $mockedRateResponse = [
            'rates' => [
                'EUR' => $euroRate
            ],
            'base' => $baseCurrency
        ];

        $rateClient->method('get')->willReturn($mockedRateResponse);

        $expectedRate = new Rate($baseCurrency, $destinationCurrency, $euroRate);
        $rateProvider = new RateProvider($rateClient);

        $this->assertEquals($expectedRate, $rateProvider->retrieveRate($baseCurrency, $destinationCurrency));
    }

    public function testItThrowsExceptionWhenRateNotAvailableInApiResponse(): void
    {
        $baseCurrency = 'GBP';
        $destinationCurrency = 'EUR';
        $euroRate = 0.8478168716;
        $rateClient = $this->createMock(RateClientInterface::class);
        $mockedRateResponse = [
            'rates' => [
                'AUD' => $euroRate
            ],
            'base' => $baseCurrency
        ];

        $rateClient->method('get')->willReturn($mockedRateResponse);

        $this->expectException(RateNotFoundException::class);
        $rateProvider = new RateProvider($rateClient);
        $rateProvider->retrieveRate($baseCurrency, $destinationCurrency);
    }

    public function testItThrowsExceptionWhenUnsupportedCurrencyProvidedInResponse(): void
    {
        $baseCurrency = 'JPY';
        $destinationCurrency = 'EUR';
        $rateClient = $this->createMock(RateClientInterface::class);
        $this->expectException(CurrencyNotSupportedException::class);
        $rateProvider = new RateProvider($rateClient);
        $rateProvider->retrieveRate($baseCurrency, $destinationCurrency);
    }
}
