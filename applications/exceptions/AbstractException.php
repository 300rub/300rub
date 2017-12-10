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

use Exception;
use testS\applications\App;

/**
 * Exception class file
 *
 * @category Applications
 * @package  Exceptions
 * @author   Mikhail Vasilev <donvasilion@gmail.com>
 * @license  http://opensource.org/licenses/gpl-license.php GNU Public License
 * @link     -
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
            if (is_array($value)) {
                $value = json_encode($value);
            }
            $message = str_replace(
                '{' . $key . '}',
                "[" . (string)$value . "]",
                $message
            );
        }

        $xRequestedWith = App::getInstance()
            ->getSuperGlobalVariable()
            ->getServerValue("HTTP_X_REQUESTED_WITH");

        $uri = App::getInstance()
            ->getSuperGlobalVariable()
            ->getServerValue("REQUEST_URI");

        if ($xRequestedWith
            && $uri
        ) {
            $message .= "\nREQUEST_URI = " . $uri;
        }

        $this->_writeLog($message);

        parent::__construct($message, $this->getErrorCode());
    }

    /**
     * Write log
     *
     * @param string $message Message
     *
     * @return void
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