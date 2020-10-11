<?php

namespace App\Service;

interface RateClientInterface
{
    public function get(string $uri): array;
}
