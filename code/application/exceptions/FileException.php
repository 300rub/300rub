<?php

namespace ss\application\exceptions;

/**
 * FileException class
 */
class FileException extends AbstractException
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
        return 'file';
    }
}
