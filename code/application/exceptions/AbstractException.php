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
//        App::getInstance()->getLogger()->error(
//            $message,
//            $parameters,
//            $this->getLogName(),
//            $this
//        );

        parent::__construct($message, $this->getErrorCode());
    }
}
