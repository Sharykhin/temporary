<?php

namespace Exceptions;

use Support\Codes;

class GenerateFileException extends \RuntimeException
{
    public function __construct($message, $code = Codes::GENERATE_FILE_ERROR, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}