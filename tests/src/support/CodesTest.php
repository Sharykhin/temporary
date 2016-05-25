<?php

namespace Tests\src\support;

use Language\Support\Codes;

/**
 * Class CodesTest
 */
class CodesTest extends \PHPUnit_Framework_TestCase
{
    public function testCodes()
    {
        $this->assertEquals(0, Codes::API_EXCEPTION);
        $this->assertEquals(1, Codes::API_WRONG_RESPONSE);
        $this->assertEquals(2, Codes::API_WRONG_CONTENT);
        $this->assertEquals(3, Codes::LANGUAGE_ERROR);
        $this->assertEquals(4, Codes::GENERATE_FILE_ERROR);
    }
}