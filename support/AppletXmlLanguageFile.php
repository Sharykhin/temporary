<?php

namespace Support;

use Contracts\GenerateFileContract;
use Contracts\ApiContract;

/**
 * Class AppletXmlLanguageFile
 * @package Support
 */
class AppletXmlLanguageFile implements GenerateFileContract
{

    /** @var ApiContract $api */
    private static $api;

    /**
     * AppletXmlLanguageFile constructor.
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