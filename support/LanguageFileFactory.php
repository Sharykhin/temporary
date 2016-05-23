<?php

namespace Support;

use Contracts\LanguageFactoryContract;

/**
 * Class LanguageFileFactory
 * @package Support
 */
class LanguageFileFactory implements LanguageFactoryContract
{
    /**
     * @return object
     */
    public function create()
    {
        return DI::create('\Support\LanguageFile');
    }
}