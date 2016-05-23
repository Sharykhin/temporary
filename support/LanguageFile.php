<?php

namespace Support;

use Contracts\GenerateFileContract;
use Contracts\ApiContract;

/**
 * Class LanguageFile
 * @package Support
 */
class LanguageFile implements GenerateFileContract
{
    /** @var ApiContract $api */
    private static $api;

    /**
     * LanguageFile constructor.
     * @param ApiContract $api
     */
    public function __construct(ApiContract $api)
    {
        self::$api = $api;
    }

    public function generateFile()
    {

    }
}