<?php

namespace App\Service;

class RateRecommendation
{
    /** @var RateProviderInterface */
    private $rateProvider;

    public function __construct(RateProviderInterface $rateProvider)
    {
        $this->rateProvider = $rateProvider;
    }

    public function isGoodRate(Rate $currentRate, string $baseCurrency, string $destinationCurrency): bool
    {
        $lastDayOfWeek = new \DateTime('now');
        $firstDayOfWeek = new \DateTime('now');
        $firstDayOfWeek->modify('-7 day');

        $lastWeekRates = $this->rateProvider->getHistoricalRates(
            $baseCurrency,
            $destinationCurrency,
            $firstDayOfWeek,
            $lastDayOfWeek
        );

        if (isset($lastWeekRates['rates'])) {
            foreach ($lastWeekRates['rates'] as $date => $rate) {
                if (isset($rate[$currentRate->getDestinationCurrency()])
                    && $currentRate->getRate() > $rate[$currentRate->getDestinationCurrency()]) {
                    return false;
                }
            }
        }

        return true;
    }
}
