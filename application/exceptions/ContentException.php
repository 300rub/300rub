<?php

namespace testS\application\exceptions;

/**
 * ContentException class
 */
class ContentException extends AbstractException
{

    /**
     * Get error code
     *
     * @return integer
     */
    protected function getErrorCode()
    {
        return 204;
    }

    /**
     * Get log name
     *
     * @return string
     */
    protected function getLogName()
    {
        return 'content';
    }
}
