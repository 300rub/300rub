<?php

namespace ss\application\exceptions;

/**
 * CommonException class
 */
class AccessException extends AbstractException
{

    /**
     * Get error code
     *
     * @return integer
     */
    public function getErrorCode()
    {
        return 403;
    }

    /**
     * Get log name
     *
     * @return string
     */
    protected function getLogName()
    {
        return 'access';
    }
}
