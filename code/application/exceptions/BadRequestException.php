<?php

namespace ss\application\exceptions;

/**
 * BadRequestException class
 */
class BadRequestException extends AbstractException
{

    /**
     * Get error code
     *
     * @return integer
     */
    protected function getErrorCode()
    {
        return 400;
    }

    /**
     * Get log name
     *
     * @return string
     */
    protected function getLogName()
    {
        return 'error-bad-request';
    }
}
