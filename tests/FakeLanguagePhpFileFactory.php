<?php

namespace Tests;

use Contracts\PhpLanguageFactoryContract;
use Support\LanguagePhpFile;


class FakeLanguagePhpFileFactory implements PhpLanguageFactoryContract
{
    public function create()
    {
        return new LanguagePhpFile(new FakeApiCall(), new FakeFileCreator());
    }
}