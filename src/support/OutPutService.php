<?php

namespace Language\Support;

use Language\Contracts\OutPutContract;

/**
 * Class OutPutService
 * @package Language\Support
 */
class OutPutService implements OutPutContract
{
    /**
     * @param string $str
     */
    public function printText($str)
    {
        echo $str;
    }
}