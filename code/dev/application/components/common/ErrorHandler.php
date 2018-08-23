<?php

namespace ss\application\components\common;

use ss\application\App;
use ss\application\exceptions\CommonException;
use ss\application\instances\Console;
use ss\application\instances\Test;
use ss\controllers\page\ErrorController;

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

        $logMessage = sprintf(
            'Exception occurred with type: [%s], message: [%s], ' .
            'file: [%s], line: [%s], backtrace: [%s]',
            get_class($exception),
            $exception->getMessage(),
            $exception->getFile(),
            $exception->getLine(),
            $exception->getTraceAsString()
        );

        if (App::getInstance() instanceof Console
            || App::getInstance() instanceof Test
        ) {
            throw new CommonException($logMessage);
        }

        App::getInstance()->getLogger()->error($logMessage, 'common');

        $errorController = new ErrorController();
        $errorController
            ->setCode($exception->getCode())
            ->setMessage($exception->getMessage())
            ->setFile($exception->getFile())
            ->setLine($exception->getLine())
            ->setBacktrace($exception->getTrace());
        echo $errorController->run();
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
        $logMessage = sprintf(
            'Error! code: [%s], message: [%s], ' .
            'file: [%s], line: [%s]',
             $code,
             $message,
             $file,
             $line
        );

        if (App::getInstance() instanceof Console
            || App::getInstance() instanceof Test
        ) {
            throw new CommonException($logMessage);
        }

        App::getInstance()->getLogger()->error($logMessage, 'common');

        $errorController = new ErrorController();
        $errorController
            ->setCode($code)
            ->setMessage($message)
            ->setFile($file)
            ->setLine($line);
        echo $errorController->run();
    }
}
