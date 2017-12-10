<?php

/**
 * PHP version 7
 *
 * @category Applications
 * @package  Exceptions
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */

namespace testS\applications\exceptions;

/**
 * BadRequestException class
 *
 * @category Applications
 * @package  Exceptions
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
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
        return "badRequest.log";
    }
}