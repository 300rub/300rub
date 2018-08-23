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
     * Ignore cache flag
     *
     * @var boolean
     */
    private $_isIgnoreCache = false;

    /**
     * Key prefix
     *
     * @var string
     */
    private $_prefix = '';

    /**
     * Memcached constructor.
     *
     * @param string $host          The hostname of the memcache server
     * @param int    $port          The port on which memcache is running
     * @param bool   $isIgnoreCache Ignore cache flag
     */
    public function __construct($host, $port, $isIgnoreCache)
    {
        $memcached = new \Memcached();

        $memcached->addServer($host, $port);

        if ($memcached->getStats() !== false) {
            $this->_memcached = $memcached;
        }

        $this->_isIgnoreCache = $isIgnoreCache;
    }

    /**
     * Sets prefix
     *
     * @param string $prefix Prefix
     *
     * @return Memcached
     */
    public function setPrefix($prefix)
    {
        $this->_prefix = $prefix;
        return $this;
    }

    /**
     * Sets value to the cache
     *
     * @param string $key            The key under which to store the value.
     * @param mixed  $value          The value to store.
     * @param int    $expiration     The expiration time, defaults to 0.
     * @param bool   $isIgnorePrefix Flag to ignore prefix
     *
     * @return Memcached
     *
     * @throws MemcacheException
     */
    public function set(
        $key,
        $value,
        $expiration = null,
        $isIgnorePrefix = null
    ) {
        if ($this->_memcached === null
            || $this->_isIgnoreCache === true
        ) {
            return $this;
        }

        if ($isIgnorePrefix !== true) {
            $key = $this->_prefix . $key;
        }

        $result = $this->_memcached->set($key, $value, $expiration);
        App::getInstance()->getLogger()->debug(
            'SET ' . $key,
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
     * @param string $key            The key of the item to retrieve.
     * @param bool   $isIgnorePrefix Flag to ignore prefix
     *
     * @return mixed
     */
    public function get($key, $isIgnorePrefix = null)
    {
        if ($this->_memcached === null
            || $this->_isIgnoreCache === true
        ) {
            return false;
        }

        if ($isIgnorePrefix !== true) {
            $key = $this->_prefix . $key;
        }

        App::getInstance()->getLogger()->debug(
            'GET ' . $key,
            'memcached'
        );

        return $this->_memcached->get($key);
    }

    /**
     * Deletes value from the cache
     *
     * @param string $key            The key to be deleted.
     * @param bool   $isIgnorePrefix Flag to ignore prefix
     *
     * @return Memcached
     *
     * @throws MemcacheException
     */
    public function delete($key, $isIgnorePrefix = null)
    {
        if ($this->_memcached === null
            || $this->_isIgnoreCache === true
            || $this->get($key) === false
        ) {
            return $this;
        }

        if ($isIgnorePrefix !== true) {
            $key = $this->_prefix . $key;
        }

        $result = $this->_memcached->delete($key);
        App::getInstance()->getLogger()->debug(
            'DELETE ' . $key,
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

    /**
     * Flushes Memcache
     *
     * @return Memcached
     *
     * @throws MemcacheException
     */
    public function flush()
    {
        if ($this->_memcached === null
            || $this->_isIgnoreCache === true
        ) {
            return $this;
        }

        $result = $this->_memcached->flush();

        if ($result === false) {
            throw new MemcacheException('Unable to flush from memcache');
        }

        return $this;
    }
}
