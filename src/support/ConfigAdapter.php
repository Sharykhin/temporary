<?php

namespace Language\Support;

use Language\Contracts\ConfigContract;
use Language\Config;

/**
 * Class ConfigAdapter
 * @package Language\Support
 */
class ConfigAdapter implements ConfigContract
{
    private $config;

    /**
     * ConfigAdapter constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param $key
     * @return array|void
     */
    public function get($key)
    {
        return $this->config->get($key);
    }
}