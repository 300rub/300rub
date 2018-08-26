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

        $superGlobalVariable = App::getInstance()
            ->getSuperGlobalVariable();

        $xRequestedWith = $superGlobalVariable
            ->getServerValue('HTTP_X_REQUESTED_WITH');

        $uri = $superGlobalVariable
            ->getServerValue('REQUEST_URI');

        if (empty($xRequestedWith) === false
            && empty($uri) === false
        ) {
            $message .= "\nREQUEST_URI = " . $uri;
        }

        $logMessage = sprintf(
            "%s\nFile: %s (%s)\nTrace:\n%s\n\n",
            $message,
            $this->getFile(),
            $this->getLine(),
            $this->getTraceAsString()
        );

        App::getInstance()->getLogger()->error(
            $logMessage,
            [],
            $this->getLogName()
        );

        parent::__construct($message, $this->getErrorCode());
    }
}
