<?php

namespace App\Exception;

use Throwable;

class ApiRuntimeException extends \RuntimeException
{
    protected $message = 'Failed to connect remote API endpoint';

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        if (empty($message)) {
            $message = $this->message;
        }

        parent::__construct($message, $code, $previous);
    }
}
