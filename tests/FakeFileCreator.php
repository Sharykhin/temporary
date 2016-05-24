<?php

namespace Tests;

use Contracts\FileCreatorContract;

class FakeFileCreator implements FileCreatorContract
{
    public function writeIntoFile($destination, $data)
    {
        return 1;
    }
}