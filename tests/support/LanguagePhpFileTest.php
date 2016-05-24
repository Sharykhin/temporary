<?php

namespace Tests;

use Tests\FakeApiCall;
use Tests\FakeFileCreator;
use Support\LanguagePhpFile;

/**
 * Class LanguagePhpFileTest
 * @package Tests
 */
class LanguagePhpFileTest extends \PHPUnit_Framework_TestCase
{
    public function testApiCalling()
    {
        $mock = $this->getMock('Tests\FakeApiCall', array('call'));

        $mock->expects($this->exactly(2))->method('call');

        $languagePhpFile = new LanguagePhpFile($mock, new FakeFileCreator());
        $languagePhpFile->generateFile();
    }

    public function testFileCreating()
    {
        $mock = $this->getMock('Tests\FakeFileCreator', array('writeIntoFile'));
        $mock->expects($this->exactly(2))->method('writeIntoFile');

        $languagePhpFile = new LanguagePhpFile(new FakeApiCall(), $mock);
        $languagePhpFile->generateFile();
    }
}