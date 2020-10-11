<?php

namespace App\Service;

class Rate
{
    /** @var float */
    private $rate;

    /** @var string */
    private $baseCurrency;

    /** @var string */
    private $destinationCurrency;

    public function __construct(string $baseCurrency, string $destinationCurrency, float $rate)
    {
        $this->baseCurrency = $baseCurrency;
        $this->destinationCurrency = $destinationCurrency;
        $this->rate = $rate;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function getBaseCurrency(): string
    {
        return $this->baseCurrency;
    }

    public function getDestinationCurrency(): string
    {
        return $this->destinationCurrency;
    }
}
