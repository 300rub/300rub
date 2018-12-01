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
    abstract public function getErrorCode();

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

        App::getInstance()->getLogger()->error(
            $message,
            [],
            $this->getLogName(),
            $this
        );

        parent::__construct($message, $this->getErrorCode());
    }
}
