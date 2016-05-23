<?php

namespace Contracts;

interface ApiContract
{
    public static function call($target, $mode, $getParameters, $postParameters);
}