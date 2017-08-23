<?php

namespace testS\components;

use testS\components\exceptions\MemcacheException;

/**
 * Class for working with Memcached
 *
 * @package testS\components
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
     * Memcached constructor.
     *
     * @param string $host
     * @param int    $port
     */
    public function __construct($host, $port)
    {
        $memcached = new \Memcached();

        $memcached->addServer($host, $port);

        if ($memcached->getStats() !== false) {
            $this->_memcached = $memcached;
        }
    }

    /**
     * Sets value to the cache
     *
     * @param string $key
     * @param mixed  $value
     * @param int    $expiration
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

        $result = $this->_memcached->set($key, $value, $expiration);

        if ($result === false) {
            throw new MemcacheException(
                "Unable to save memcache with key: {key}, value: {value}, expiration: {expiration}",
                [
                    "key"        => $key,
                    "value"      => $value,
                    "expiration" => $expiration
                ]
            );
        }

        return $this;
    }

    /**
     * Gets value from memcache by key
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get($key)
    {
        if ($this->_memcached === null) {
            return false;
        }

        return $this->_memcached->get($key);
    }

    /**
     * Deletes value from the cache
     *
     * @param string $key
     *
     * @return Memcached
     *
     * @throws MemcacheException
     */
    public function delete($key)
    {
        if ($this->_memcached === null) {
            return $this;
        }

        if ($this->get($key) === false) {
            return $this;
        }

        $result = $this->_memcached->delete($key);

        if ($result === false) {
            throw new MemcacheException(
                "Unable to delete from memcache with key: {key}",
                [
                    "key" => $key,
                ]
            );
        }

        return $this;
    }
}