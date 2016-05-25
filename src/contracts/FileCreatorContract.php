<?php

namespace Language\Contracts;

interface FileCreatorContract
{
    public function writeIntoFile($destination, $data);
}