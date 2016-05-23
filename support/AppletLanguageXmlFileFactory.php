<?php

namespace Support;

use Contracts\LanguageFactoryContract;

/**
 * Class LanguageFileFactory
 * @package Support
 */
class AppletLanguageXmlFileFactory implements LanguageFactoryContract
{
    /**
     * @return object
     */
    public function create()
    {
        return DI::create('\Support\AppletXmlLanguageFile');
    }
}