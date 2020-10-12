<?php

namespace App\Exception;

use Throwable;

class CurrencyNotSupportedException extends \RuntimeException
{
    protected $message = 'Currently we dont support base currency: %s';

    public function __construct($currencyCode = "", $code = 0, Throwable $previous = null)
    {
        $message = sprintf($this->message, $currencyCode);

        parent::__construct($message, $code, $previous);
    }
}
