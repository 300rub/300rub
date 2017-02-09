<?php

namespace testS\components\exceptions;

use Exception;

/**
 * Exception class file
 *
 * @package testS\components
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
     * @param string $message
     * @param array  $parameters
     */
    public function __construct($message, array $parameters = [])
    {
        foreach ($parameters as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }
            $message = str_replace('{' . $key . '}', "[" . (string)$value . "]", $message);
        }

        if (
            empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && isset($_SERVER['REQUEST_URI'])
        ) {
            $message .= "\nREQUEST_URI = " . $_SERVER['REQUEST_URI'];
        }

        $this->_writeLog($message);

        parent::__construct($message, $this->getErrorCode());
    }

    /**
     * Write log
     *
     * @param string $message
     */
    private function _writeLog($message)
    {
        $logMessage = sprintf(
            "[%s] %s\nFile: %s\nLine: %s\nTrace:\n%s\n\n",
            date("Y-m-d H:i:s", time()),
            $message,
            $this->getFile(),
            $this->getLine(),
            $this->getTraceAsString()
        );

        $logFolder = __DIR__ . "/../../logs";
        $logFile = $logFolder . "/" . $this->getLogName();

        $file = @fopen($logFile, "a");
        @flock($file, LOCK_EX);
        @fwrite($file, $logMessage);
        @flock($file, LOCK_UN);
        @fclose($file);
    }
}