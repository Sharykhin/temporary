<?php

namespace Exceptions;

use Support\Codes;

/**
 * Class LanguageFileException
 * @package Exceptions
 */
class LanguageFileException extends \LogicException
{
    /** @var string $language  */
    private $language;

    /**
     * LanguageFileException constructor.
     * @param string $language
     * @param \Exception $message
     * @param $code
     * @param \Exception $previous
     */
    public function __construct(      
        $language,
        $message,
        $code = Codes::LANGUAGE_FILE_ERROR,
        \Exception $previous = null)
    {        
        $this->language = $language;
        parent::__construct($message, $code, $previous);
    }


    /**
     * Return a language
     * @return int|string
     */
    public function getLanguage()
    {
        return $this->language;
    }
}