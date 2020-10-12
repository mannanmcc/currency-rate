<?php

namespace App\Controller;

use App\Service\RateProviderInterface;
use App\Service\RateRecommendation;
use Symfony\Component\HttpFoundation\Response;

class ExchangeRateController
{
    private static $DESTINATION_CURRENCY = 'EUR';
    private static $RECOMMENDATION_MESSAGE = 'Exchange rate is too high today';

    public function rate(RateProviderInterface $rateProvider, RateRecommendation $recommendation, string $currency)
    {
        $baseCurrency = strtoupper($currency);
        $currentRate = $rateProvider->retrieveRate($baseCurrency, static::$DESTINATION_CURRENCY);
        $content = [
            'currency' => static::$DESTINATION_CURRENCY,
            'base' => $baseCurrency,
            'rate' => $currentRate->getRate()
        ];

        if (!$recommendation->isGoodRate($currentRate, $baseCurrency, static::$DESTINATION_CURRENCY)) {
            $content['message'] = static::$RECOMMENDATION_MESSAGE;
        }

        $response = new Response();
        $response->setContent(json_encode($content));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
