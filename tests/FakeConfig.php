<?php

namespace Tests;

use Language\Contracts\ConfigContract;

class FakeConfig implements ConfigContract
{
    public function get($key)
    {
        switch ($key) {
            case 'system.translated_applications':
                return array('test' => array('en', 'hu', 'fr'));

            case 'system.paths.root' :
                return realpath(dirname(__FILE__) . '/');
                break;
        }
    }
}