<?php

namespace Tests\src\support;

use Tests\FakeApiCall;
use Tests\FakeFileCreator;
use Tests\FakeConfig;
use Tests\FakeOutPutService;
use Language\Support\LanguagePhpFile;

/**
 * Class LanguagePhpFileTest
 * @package Tests
 */
class LanguagePhpFileTest extends \PHPUnit_Framework_TestCase
{

    public function testApiCalling()
    {
        $mock = $this->getMockBuilder('Language\Support\ApiAdapter')
            ->setMethods(array('call'))
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->exactly(3))->method('call');

        $languagePhpFile = new LanguagePhpFile($mock, new FakeFileCreator(), new FakeOutPutService(), new FakeConfig());
        $languagePhpFile->generateFile();
    }

    public function testFileCreating()
    {
        $mock = $this->getMock('Language\Support\FileCreator', array('writeIntoFile'));
        $mock->expects($this->exactly(3))->method('writeIntoFile');

        $languagePhpFile = new LanguagePhpFile(new FakeApiCall(), $mock, new FakeOutPutService(), new FakeConfig());
        $languagePhpFile->generateFile();
    }
}