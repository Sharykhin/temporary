<?php

namespace Tests;

use Tests\FakeApiCall;
use Tests\FakeFileCreator;
use Support\AppletXmlLanguageFile;
use Exceptions\GenerateFileException;

class AppletXmlLanguageFileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException     \Exceptions\GenerateFileException
     * @expectedExceptionCode 4
     */
    public function testGenerateFileException()
    {
        $languagePhpFile = new AppletXmlLanguageFile(new FakeApiCall(), new FakeFileCreator());
        $languagePhpFile->generateFile();
    }


}