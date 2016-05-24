<?php

namespace Support;

use Contracts\PhpLanguageFactoryContract;

/**
 * Class LanguageFileFactory
 * @package Support
 */
class LanguagePhpFileFactory implements PhpLanguageFactoryContract
{
    /**
     * @return object
     */
    public function create()
    {
        return DI::create('\Support\LanguagePhpFile');
    }
}