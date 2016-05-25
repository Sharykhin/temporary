<?php

namespace Tests;

use Language\Contracts\LanguageFactoryContract;
use Language\Support\AppletXmlLanguageFile;

class FakeAppletLanguageXmlFileFactory implements LanguageFactoryContract
{
    public function create()
    {
        return new AppletXmlLanguageFile(new FakeApiCall(), new FakeFileCreator());
    }
}