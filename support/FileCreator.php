<?php

namespace Support;

use Contracts\FileCreatorContract;

/**
 * Class FileCreator
 * @package Support
 */
class FileCreator implements FileCreatorContract
{
    /**
     * @param $destination
     * @param $data
     * @return mixed
     */
    public function writeIntoFile($destination, $data)
    {
        return file_put_contents($destination, $data);       
    }
}