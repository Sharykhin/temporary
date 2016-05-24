<?php

use Support\FileCreator;

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