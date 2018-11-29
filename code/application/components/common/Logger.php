<?php

namespace ss\application\components\common;
use ss\application\App;
use ss\application\exceptions\AbstractException;

/**
 * Class to work with logs
 */
class Logger
{

    /**
     * Level info
     */
    const LEVEL_INFO = 'info';

    /**
     * Level warning
     */
    const LEVEL_WARNING = 'warning';

    /**
     * Level error
     */
    const LEVEL_ERROR = 'error';

    /**
     * Level bug
     */
    const LEVEL_DEBUG = 'debug';

    /**
     * Default file name
     */
    const DEFAULT_NAME = 'common';

    /**
     * Logs the message
     *
     * @param string $message    Message
     * @param array  $parameters Parameters
     * @param string $name       File name
     * @param string $level      Level
     *
     * @return void
     */
    private function _log($message, $parameters, $name, $level) {
        foreach ($parameters as $key => $value) {
            if (is_array($value) === true) {
                $value = json_encode($value);
            }

            $message = str_replace(
                '{' . $key . '}',
                '[' . (string)$value . ']',
                $message
            );
        }

        $filePath = sprintf(
            '%s/logs/%s-%s.log',
            FILES_ROOT,
            $level,
            $name
        );

        $isNew = false;
        if (file_exists($filePath) === false) {
            $isNew = true;
        }

        $logMessage = sprintf(
            '[%s] [%s] %s%s',
            date('Y-m-d H:i:s', time()),
            $name,
            $message,
            PHP_EOL
        );

        echo $filePath;
        echo $logMessage; exit;
//        $file = fopen($filePath, 'a');
//        flock($file, LOCK_EX);
//        fwrite($file, $logMessage);
//        flock($file, LOCK_UN);
//        fclose($file);

//        if ($isNew === true) {
//            chmod($filePath, 0777);
//        }
    }

    /**
     * Logs warning message
     *
     * @param string $message    Message
     * @param array  $parameters Parameters
     * @param string $name       File name
     *
     * @return void
     */
    public function info(
        $message,
        array $parameters = [],
        $name = self::DEFAULT_NAME
    ) {
        $this->_log($message, $parameters, $name, self::LEVEL_INFO);
    }

    /**
     * Logs warning message
     *
     * @param string $message    Message
     * @param array  $parameters Parameters
     * @param string $name       File name
     *
     * @return void
     */
    public function warning(
        $message,
        array $parameters = [],
        $name = self::DEFAULT_NAME
    ) {
        $message .= $this->_getRequestInfo();
        $this->_log($message, $parameters, $name, self::LEVEL_WARNING);
    }

    /**
     * Logs error
     *
     * @param string     $message    Message
     * @param array      $parameters Parameters
     * @param string     $name       File name
     * @param \Exception $exception  Exception
     *
     * @return void
     */
    public function error(
        $message,
        array $parameters = [],
        $name = self::DEFAULT_NAME,
        $exception = null
    ) {
        if ($exception !== null) {
            $errorCode = $exception->getCode();
            if ($exception instanceof AbstractException) {
                $errorCode = $exception->getErrorCode();
            }

            $message = sprintf(
                "%s CODE: %s FILE: %s (%s) TRACE: %s",
                $message,
                $errorCode,
                $exception->getFile(),
                $exception->getLine(),
                str_replace(PHP_EOL, ' ', $exception->getTraceAsString())
            );
        }

        $message .= $this->_getRequestInfo();

        $this->_log($message, $parameters, $name, self::LEVEL_ERROR);
    }

    /**
     * Logs debug message
     *
     * @param string $message    Message
     * @param array  $parameters Parameters
     * @param string $name       File name
     *
     * @return void
     */
    public function debug(
        $message,
        array $parameters = [],
        $name = self::DEFAULT_NAME
    ) {
        if (APP_ENV === ENV_DEV) {
            $this->_log($message, $parameters, $name, self::LEVEL_DEBUG);
        }
    }

    /**
     * Gets request info
     *
     * @return string
     */
    private function _getRequestInfo()
    {
        $info = '';

        $superGlobalVariable = App::getInstance()
            ->getSuperGlobalVariable();

        $uri = $superGlobalVariable
            ->getServerValue('REQUEST_URI');
        $httpHost = $superGlobalVariable
            ->getServerValue('HTTP_HOST');
        if (empty($uri) === false
            || empty($httpHost) === false
        ) {
            $info .= sprintf(
                ' URL: %s%s',
                $httpHost,
                $uri
            );
        }

        $get = $superGlobalVariable->getGetValue();
        if (empty($get) === false) {
            $info .= sprintf(
                ' GET: %s',
                json_encode($get)
            );
        }

        $post = $superGlobalVariable->getPostValue();
        if (empty($post) === false) {
            $info .= sprintf(
                ' POST: %s',
                json_encode($post)
            );
        }

        $files = $superGlobalVariable->getFilesValue();
        if (empty($files) === false) {
            $info .= sprintf(
                ' FILES: %s',
                json_encode($files)
            );
        }

        $put = file_get_contents('php://input');
        if (empty($put) === false) {
            $info .= sprintf(
                ' PUT: %s',
                $put
            );
        }

        return $info;
    }
}
