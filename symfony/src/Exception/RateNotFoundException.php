<?php

namespace App\Exception;

use Throwable;

class RateNotFoundException extends \RuntimeException
{
    protected $message = 'Expected rate not found';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            $message = $this->message;
        }

        parent::__construct($message, $code, $previous);
    }
}
