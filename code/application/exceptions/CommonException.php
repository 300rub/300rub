<?php

namespace ss\application\exceptions;

/**
 * CommonException class
 */
class CommonException extends AbstractException
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
        return 'common';
    }
}
