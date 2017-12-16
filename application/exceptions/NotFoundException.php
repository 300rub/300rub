<?php

namespace testS\application\exceptions;

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
    protected function getErrorCode()
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
        return 'notFound.log';
    }
}
