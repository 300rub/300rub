<?php

namespace testS\applications\exceptions;

/**
 * MigrationException class
 */
class MigrationException extends AbstractException
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
        return 'migration.log';
    }
}
