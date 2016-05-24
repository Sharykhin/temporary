<?php

namespace Contracts;

/**
 * Interface ApiContract
 * @package Contracts
 */
interface ApiContract
{
    public function call($target, $mode, $getParameters, $postParameters);
}