<?php

namespace ss\application\exceptions;

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
    public function getErrorCode()
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
