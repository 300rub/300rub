<?php

namespace testS\applications\exceptions;

/**
 * MemcacheException class file
 */
class MemcacheException extends AbstractException
{

    /**
     * Get error code
     *
     * @return integer
     */
    protected function getErrorCode()
    {
        return 500;
    }

    /**
     * Get log name
     *
     * @return string
     */
    protected function getLogName()
    {
        return 'memcache.log';
    }
}
