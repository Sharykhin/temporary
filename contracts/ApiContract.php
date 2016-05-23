<?php

namespace Contracts;

/**
 * Interface ApiContract
 * @package Contracts
 */
interface ApiContract
{
    public static function call($target, $mode, $getParameters, $postParameters);
}