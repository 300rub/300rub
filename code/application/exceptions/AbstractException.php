<?php

namespace ss\application\exceptions;

use Exception;
use ss\application\App;

/**
 * Exception class file
 */
abstract class AbstractException extends Exception
{

    /**
     * Get error code
     *
     * @return integer
     */
    abstract protected function getErrorCode();

    /**
     * Get log name
     *
     * @return string
     */
    abstract protected function getLogName();

    /**
     * AbstractException constructor.
     *
     * @param string $message    Message
     * @param array  $parameters Parameters
     */
    public function __construct($message, array $parameters = [])
    {
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

        $logMessage = sprintf(
            "%s FILE: %s (%s) TRACE: %s%s",
            $message,
            $this->getFile(),
            $this->getLine(),
            str_replace(PHP_EOL, ' ', $this->getTraceAsString()),
            $this->_getRequestInfo()
        );

        App::getInstance()->getLogger()->error(
            $logMessage,
            [],
            $this->getLogName()
        );

        parent::__construct($message, $this->getErrorCode());
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
