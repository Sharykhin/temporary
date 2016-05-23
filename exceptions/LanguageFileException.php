<?php

namespace Exceptions;

use Support\Codes;

/**
 * Class LanguageFileException
 * @package Exceptions
 */
class LanguageFileException extends \LogicException
{
    /** @var string $application */
    private $application;
    /** @var string $language  */
    private $language;

    /**
     * LanguageFileException constructor.
     * @param string $application
     * @param int $language
     * @param \Exception $message
     * @param $code
     * @param \Exception $previous
     */
    public function __construct(
        $application,
        $language,
        $message,
        $code = Codes::LANGUAGE_FILE_ERROR,
        \Exception $previous = null)
    {
        $this->application = $application;
        $this->language = $language;

        parent::__construct($message, $code, $previous);
    }

    /**
     * Return an application
     * @return string
     */
    public function getApplication()
    {
        return $this->application;
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