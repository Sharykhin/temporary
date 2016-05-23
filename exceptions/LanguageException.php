<?php

namespace Exceptions;

use Support\Codes;

/**
 * Class LanguageFileException
 * @package Exceptions
 */
class LanguageException extends \LogicException
{
    public function __construct($message, $code = Codes::LANGUAGE_ERROR, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}