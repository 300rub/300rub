<?php

/**
 * PHP version 7
 *
 * @category Applications
 * @package  Components
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */

namespace testS\applications\components;

use testS\applications\exceptions\CommonException;

/**
 * Class for handling errors
 *
 * @category Applications
 * @package  Components
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
 */
class ErrorHandler
{
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_setErrorReporting()->_setExceptionHandler();
    }

    /**
     * Sets error reporting
     *
     * @return ErrorHandler
     */
    private function _setErrorReporting()
    {
        ini_set("error_reporting", E_ALL);
        ini_set("display_errors", "On");

        return $this;
    }

    /**
     * Sets exception handler
     *
     * @return ErrorHandler
     */
    private function _setExceptionHandler()
    {
        set_exception_handler([$this, 'handleException']);
        set_error_handler([$this, 'handleError'], error_reporting());

        return $this;
    }

    /**
     * Handles exceptions
     *
     * @param \Exception $exception Exception
     * 
     * @throws CommonException
     *
     * @return void
     */
    public function handleException($exception)
    {
        restore_error_handler();
        restore_exception_handler();

        throw new CommonException(
            "Exception occurred with type: {type}, message: {message}, " .
            "file: {file}, line: {line} backtrace: {backtrace}",
            [
                "type"      => get_class($exception),
                "message"   => $exception->getMessage(),
                "file"      => $exception->getFile(),
                "line"      => $exception->getLine(),
                "backtrace" => $exception->getTraceAsString()
            ]
        );
    }

    /**
     * Handles errors
     *
     * @param int    $code    Code
     * @param string $message Message
     * @param string $file    File
     * @param int    $line    Line number
     *
     * @throws CommonException
     *
     * @return void
     */
    public function handleError($code, $message, $file, $line)
    {
        throw new CommonException(
            "Error! code: {code}, message: {message}, file: {file}, line: {line}",
            [
                "code"    => $code,
                "message" => $message,
                "file"    => $file,
                "line"    => $line
            ]
        );
    }
}