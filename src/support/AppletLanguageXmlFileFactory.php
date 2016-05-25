<?php

namespace Language\Support;

use Language\Contracts\LanguageFactoryContract;

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
        return DI::create('\Language\Support\AppletXmlLanguageFile');
    }
}