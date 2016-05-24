<?php

namespace Tests;

use Contracts\ApiContract;

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