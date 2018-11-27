<?php

namespace ss\application\components\common;

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
            '[%s] [%s] %s',
            date('Y-m-d H:i:s', time()),
            $name,
            $message,
            PHP_EOL
        );

        $file = fopen($filePath, 'a');
        flock($file, LOCK_EX);
        fwrite($file, $logMessage);
        flock($file, LOCK_UN);
        fclose($file);

        if ($isNew === true) {
            chmod($filePath, 0777);
        }
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
        $this->_log($message, $parameters, $name, self::LEVEL_WARNING);
    }

    /**
     * Logs error
     *
     * @param string $message    Message
     * @param array  $parameters Parameters
     * @param string $name       File name
     *
     * @return void
     */
    public function error(
        $message,
        array $parameters = [],
        $name = self::DEFAULT_NAME
    ) {
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
}
