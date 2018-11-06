<?php

namespace ss\application\components\common;

use ss\application\App;
use ss\application\exceptions\CommonException;
use ss\application\instances\_abstract\AbstractAjax;
use ss\application\instances\Console;
use ss\application\instances\Phpunit;
use ss\application\instances\Selenium;
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
     *
     * @SuppressWarnings(PMD.StaticAccess)
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
            || App::getInstance() instanceof Phpunit
            || App::getInstance() instanceof Selenium
            || $this->_isApi() === true
        ) {
            throw new CommonException($logMessage);
        }

        App::getInstance()->getLogger()->error(
            $logMessage,
            [],
            'common'
        );

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
     *
     * @SuppressWarnings(PMD.StaticAccess)
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
            || App::getInstance() instanceof Phpunit
            || App::getInstance() instanceof Selenium
            || $this->_isApi() === true
        ) {
            throw new CommonException($logMessage);
        }

        App::getInstance()->getLogger()->error(
            $logMessage,
            [],
            'common'
        );

        $errorController = new ErrorController();
        $errorController
            ->setCode($code)
            ->setMessage($message)
            ->setFile($file)
            ->setLine($line);
        echo $errorController->run();
    }

    /**
     * Checks if is API
     *
     * @return bool
     */
    private function _isApi()
    {
        $requestUri = App::getInstance()
            ->getSuperGlobalVariable()
            ->getServerValue('REQUEST_URI');

        if ($requestUri === null) {
            return false;
        }

        $requestUri = trim($requestUri, '/');
        if (strpos($requestUri, AbstractAjax::API_PREFIX) === 0) {
            return true;
        }

        return false;
    }
}
