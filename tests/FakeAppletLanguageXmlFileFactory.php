<?php

namespace Tests;

use Contracts\XmlLanguageFactoryContract;
use Support\AppletXmlLanguageFile;

class FakeAppletLanguageXmlFileFactory implements XmlLanguageFactoryContract
{
    public function create()
    {
        return new AppletXmlLanguageFile(new FakeApiCall(), new FakeFileCreator());
    }
}