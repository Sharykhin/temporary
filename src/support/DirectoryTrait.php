<?php

namespace Language\Support;

use Language\Config;

/**
 * Class DirectoryTrait
 * @package Language\Support
 */
trait DirectoryTrait
{
    /**
     * @param $destination
     */
    protected function createDir($destination)
    {
        $root = Config::get("system.paths.root");
        $destination = trim(str_replace($root, '',$destination),"/");
        $path = str_replace("\\", "/", $destination);
        $path = explode("/", $path);
        $rebuild = '';
        foreach($path as $p) {

            if(strstr($p, ":") != false) {
                $rebuild = $p;
                continue;
            }
            $rebuild .= "/$p";

            if(!is_dir($root . $rebuild)) {
                mkdir($rebuild, 0755, true);
            }
        }
    }
}