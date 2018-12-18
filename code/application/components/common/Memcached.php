<?php

namespace ss\application\components\common;

use ss\application\App;
use ss\application\exceptions\MemcacheException;

/**
 * Class for working with Memcached
 */
class Memcached
{

    /**
     * Object
     *
     * @var \Memcached
     */
    private $_memcached = null;

    /**
     * The expiration time, defaults to 0.
     *
     * @var integer
     */
    private $_expiration = 0;

    /**
     * Memcached constructor.
     *
     * @param string $host       The hostname of the memcache server
     * @param int    $port       The port on which memcache is running
     * @param int    $expiration The expiration time, defaults to 0.
     */
    public function __construct($host, $port, $expiration)
    {
        $memcached = new \Memcached();

        $memcached->addServer($host, $port);
        $this->_expiration = $expiration;

        if ($memcached->getStats() !== false) {
            $this->_memcached = $memcached;
        }
    }

    /**
     * Sets value to the cache
     *
     * @param string $key        The key under which to store the value.
     * @param mixed  $value      The value to store.
     * @param int    $expiration The expiration time, defaults to 0.
     *
     * @return Memcached
     *
     * @throws MemcacheException
     */
    public function set($key, $value, $expiration = null)
    {
        if ($this->_memcached === null) {
            return $this;
        }

        if ($expiration === null) {
            $expiration = $this->_expiration;
        }

        $result = $this->_memcached->set($key, $value, $expiration);
        App::getInstance()->getLogger()->debug(
            'SET ' . $key,
            [],
            'memcached'
        );

        if ($result === false) {
            throw new MemcacheException(
                'Unable to save memcache with key: {key}, ' .
                'value: {value}, expiration: {expiration}',
                [
                    'key'        => $key,
                    'value'      => $value,
                    'expiration' => $expiration
                ]
            );
        }

        return $this;
    }

    /**
     * Gets value from memcache by key
     *
     * @param string $key The key of the item to retrieve.
     *
     * @return mixed
     */
    public function get($key)
    {
        if ($this->_memcached === null) {
            return false;
        }

        App::getInstance()->getLogger()->debug(
            'GET ' . $key,
            [],
            'memcached'
        );

        return $this->_memcached->get($key);
    }

    /**
     * Deletes value from the cache
     *
     * @param string $key The key to be deleted.
     *
     * @return Memcached
     *
     * @throws MemcacheException
     */
    public function delete($key)
    {
        if ($this->_memcached === null
            || $this->get($key) === false
        ) {
            return $this;
        }

        $result = $this->_memcached->delete($key);
        App::getInstance()->getLogger()->debug(
            'DELETE ' . $key,
            [],
            'memcached'
        );

        if ($result === false) {
            throw new MemcacheException(
                'Unable to delete from memcache with key: {key}',
                [
                    'key' => $key,
                ]
            );
        }

        return $this;
    }
}
