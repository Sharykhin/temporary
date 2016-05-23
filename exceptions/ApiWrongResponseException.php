<?php

namespace Exceptions;

use Support\Codes;

/**
 * Class ApiWrongResponseException
 * @package Exceptions
 */
class ApiWrongResponseException extends ApiException
{
    /** @var string  */
    private $status;

    /**
     * ApiWrongResponseException constructor.
     * @param string $status
     * @param int $message
     * @param \Exception $code
     * @param \Exception $previous
     */
    public function __construct($status, $message, $code = Codes::API_WRONG_RESPONSE, \Exception $previous = null)
    {
        $this->status = $status;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Return wrong status
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }
}