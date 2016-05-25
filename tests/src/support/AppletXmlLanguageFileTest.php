<?php

namespace Tests;

use Tests\FakeApiCall;
use Tests\FakeFileCreator;
use Language\Support\AppletXmlLanguageFile;
use Language\Exceptions\GenerateFileException;

class AppletXmlLanguageFileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException     \Language\Exceptions\GenerateFileException
     * @expectedExceptionCode 4
     */
    public function testGenerateFileException()
    {
        $languagePhpFile = new AppletXmlLanguageFile(new FakeApiCall(), new FakeFileCreator());
        $languagePhpFile->generateFile();
    }


}