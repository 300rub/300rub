<?php

namespace ss\application\exceptions;

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
    public function getErrorCode()
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
        return 'memcache';
    }
}
