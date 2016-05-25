<?php

namespace Tests;

use Language\Contracts\OutPutContract;

/**
 * Class FakeOutPutService
 * @package Language\Support
 */
class FakeOutPutService implements OutPutContract
{
    /**
     * Do not out put in fake implementation
     * @param $str
     */
    public function printText($str)
    {

    }
}