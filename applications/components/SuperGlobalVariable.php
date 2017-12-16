<?php

namespace testS\applications\components;

/**
 * Class to work with super-global variables
 */
class SuperGlobalVariable
{

    /**
     * $_SERVER
     *
     * @var array
     */
    private $_server = [];

    /**
     * SuperGlobalVariable constructor.
     *
     * @SuppressWarnings(PHPMD)
     */
    public function __construct()
    {
        $this->_server = $_SERVER;
    }

    /**
     * Gets $_SERVER value by key
     *
     * @param string $key Server key
     *
     * @return mixed|null
     */
    public function getServerValue($key)
    {
        if (array_key_exists($key, $this->_server) === true) {
            return $this->_server[$key];
        }

        return null;
    }
}
