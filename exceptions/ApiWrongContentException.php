<?php

namespace Exceptions;

use Support\Codes;

/**
 * Class ApiWrongContentException
 * @package Exceptions
 */
class ApiWrongContentException extends ApiException
{
    /** @var string  */
    private $content;

    /**
     * ApiWrongContentException constructor.
     * @param string $content
     * @param int $message
     * @param \Exception $code
     * @param \Exception $previous
     */
    public function __construct($content, $message, $code = Codes::API_WRONG_CONTENT, \Exception $previous = null)
    {
        $this->content = $content;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Return wrong content
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}