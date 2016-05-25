<?php

namespace Tests;

use Language\Contracts\ApiContract;

class FakeApiCall implements ApiContract
{
    public function call($target, $mode, $getParameters, $postParameters)
    {
         return [
            'status' => 'OK',
            'data'   => '',
        ];
    }
}