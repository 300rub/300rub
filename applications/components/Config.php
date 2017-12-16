<?php

namespace testS\applications\components;

/**
 * Class for working with config
 */
class Config
{

    /**
     * Config
     *
     * @var array
     */
    private $_config;

    /**
     * Config constructor.
     *
     * @param array $config Configuration
     */
    public function __construct($config)
    {
        $this->_config = $config;
    }

    /**
     * Gets config value
     *
     * @param array $path Path for config item
     *
     * @return mixed
     */
    public function getValue(array $path = [])
    {
        $value = $this->_config;

        if (count($path) === 0) {
            return $value;
        }

        foreach ($path as $item) {
            if (is_array($value) === false
                || array_key_exists($item, $value) === false
            ) {
                return null;
            }

            $value = $value[$item];
        }

        return $value;
    }
}
