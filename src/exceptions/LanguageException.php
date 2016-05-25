<?php

namespace Language\Exceptions;

use Language\Support\Codes;

/**
 * Class LanguageFileException
 * @package Exceptions
 */
class LanguageException extends \LogicException
{
    /**
     * LanguageException constructor.
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message, $code = Codes::LANGUAGE_ERROR, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}