<?php

namespace App\Controller;

use App\Service\RateProviderInterface;
use App\Service\RateRecommendation;
use Symfony\Component\HttpFoundation\Response;

class ExchangeRateController
{
    public function rate(RateProviderInterface $rateProvider, RateRecommendation $recommendation)
    {
        $baseCurrency = 'GBP';
        $destinationCurrency = 'EUR';
        $currentRate = $rateProvider->retrieveRate($baseCurrency, $destinationCurrency);
        $content = ['rate' => $currentRate->getRate()];

        if (!$recommendation->isGoodRate($currentRate, $baseCurrency, $destinationCurrency)) {
            $content['message'] = 'current rate is too high today';
        }

        $response = new Response(
            'Content',
            Response::HTTP_OK,
            ['content-type' => 'text/html']
        );

        $response->setContent(json_encode($content));

        return $response;
    }
}
