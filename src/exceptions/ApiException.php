<?php

namespace Language\Exceptions;

use Language\Support\Codes;

/**
 * Class ApiException
 * @package Exceptions
 */
class ApiException extends \RuntimeException
{
    public function __construct($message, $code = Codes::API_EXCEPTION, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}