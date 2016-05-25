<?php

namespace Language\Support;

use Language\Contracts\LanguageFactoryContract;

/**
 * Class LanguageFileFactory
 * @package Support
 */
class LanguagePhpFileFactory implements LanguageFactoryContract
{
    /**
     * @return object
     */
    public function create()
    {
        return DI::create('\Support\LanguagePhpFile');
    }
}