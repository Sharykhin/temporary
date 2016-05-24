<?php

namespace Contracts;

interface FileCreatorContract
{
    public function writeIntoFile($destination, $data);
}