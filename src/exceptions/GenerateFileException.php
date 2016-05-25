<?php

namespace Language\Exceptions;

use Language\Support\Codes;

/**
 * Class GenerateFileException
 * @package Language\Exceptions
 */
class GenerateFileException extends \RuntimeException
{
    /**
     * GenerateFileException constructor.
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message, $code = Codes::GENERATE_FILE_ERROR, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}