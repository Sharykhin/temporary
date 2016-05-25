<?php

namespace Tests;

use Language\Contracts\LanguageFactoryContract;
use Language\Support\LanguagePhpFile;


class FakeLanguagePhpFileFactory implements LanguageFactoryContract
{
    public function create()
    {
        return new LanguagePhpFile(new FakeApiCall(), new FakeFileCreator());
    }
}