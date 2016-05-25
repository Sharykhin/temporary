<?php

namespace Tests\src\support;

use Language\Support\FileCreator;

/**
 * Class FileCreatorTest
 * @package Tests\src\support
 */
class FileCreatorTest extends \PHPUnit_Framework_TestCase
{
    protected $tmpFile = "file.tmp";

    protected $fileCreator;

    /**
     * @before
     */
    protected function initialize()
    {
        $this->fileCreator = new FileCreator();
    }

    /**
     * @after
     */
    protected function clearFile()
    {
        if(file_exists(__DIR__. "/" . $this->tmpFile)) {
            unlink(__DIR__. "/" . $this->tmpFile);
        }
    }

    public function testWriteIntoFile()
    {
        $numberOfBytes = $this->fileCreator->writeIntoFile(__DIR__ . "/" . $this->tmpFile, 'test');
        $this->assertEquals($numberOfBytes, 4);
    }
}