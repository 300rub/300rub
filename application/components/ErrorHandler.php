<?php

namespace ss\application\components;

use ss\application\exceptions\CommonException;

/**
 * Class for handling errors
 */
class ErrorHandler
{

    /**
     * Sets error reporting
     *
     * @return ErrorHandler
     */
    public function setErrorReporting()
    {
        ini_set('error_reporting', E_ALL);
        ini_set('display_errors', 'On');

        return $this;
    }

    /**
     * Sets exception handler
     *
     * @return ErrorHandler
     */
    public function setExceptionHandler()
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
            'Exception occurred with type: {type}, message: {message}, ' .
            'file: {file}, line: {line} backtrace: {backtrace}',
            [
                'type'      => get_class($exception),
                'message'   => $exception->getMessage(),
                'file'      => $exception->getFile(),
                'line'      => $exception->getLine(),
                'backtrace' => $exception->getTraceAsString()
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
            'Error! code: {code}, message: {message}, ' .
            'file: {file}, line: {line}',
            [
                'code'    => $code,
                'message' => $message,
                'file'    => $file,
                'line'    => $line
            ]
        );
    }
}
