<?php

use Support\Codes;

class CodesTest extends \PHPUnit_Framework_TestCase
{
    public function testCodes()
    {
        $this->assertEquals(Codes::API_EXCEPTION, 0);
        $this->assertEquals(Codes::API_WRONG_RESPONSE, 1);
        $this->assertEquals(Codes::API_WRONG_CONTENT, 2);
        $this->assertEquals(Codes::LANGUAGE_ERROR, 3);
        $this->assertEquals(Codes::GENERATE_FILE_ERROR, 4);
    }
}