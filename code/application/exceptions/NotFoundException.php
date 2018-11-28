<?php

namespace ss\application\exceptions;

/**
 * NotFoundException class
 */
class NotFoundException extends AbstractException
{

    /**
     * Get error code
     *
     * @return integer
     */
    public function getErrorCode()
    {
        return 404;
    }

    /**
     * Get log name
     *
     * @return string
     */
    protected function getLogName()
    {
        return 'not-found';
    }
}
