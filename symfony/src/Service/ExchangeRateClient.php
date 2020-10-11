<?php

namespace App\Service;

use App\Exception\ApiRuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\ContainerBagInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExchangeRateClient implements RateClientInterface
{
    /** @var string */
    private static $GET_METHOD = 'GET';

    /** @var HttpClientInterface */
    private $client;

    /** @var ContainerBagInterface */
    private $params;

    public function __construct(HttpClientInterface $client, ContainerBagInterface $params)
    {
        $this->client = $client;
        $this->params = $params;
    }

    public function get(string $uri): array
    {
        $fullUrl = $this->params->get('rate.base_url') . $uri;

        try {
            $response = $this->client->request(
                static::$GET_METHOD,
                $fullUrl
            );

            if ($response->getStatusCode() != 200) {
                throw new ApiRuntimeException();
            }

            return $response->toArray(true);
        } catch (\Exception $e) {
            throw new ApiRuntimeException();
        }
    }
}
