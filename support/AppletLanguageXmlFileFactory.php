<?php

namespace Support;

use Contracts\XmlLanguageFactoryContract;

/**
 * Class LanguageFileFactory
 * @package Support
 */
class AppletLanguageXmlFileFactory implements XmlLanguageFactoryContract
{
    /**
     * @return object
     */
    public function create()
    {
        return DI::create('\Support\AppletXmlLanguageFile');
    }
}