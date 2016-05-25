<?php

namespace Tests;

use Language\Contracts\FileCreatorContract;

class FakeFileCreator implements FileCreatorContract
{
    public function writeIntoFile($destination, $data)
    {
        return 1;
    }
}