<?php

namespace ss\application\components;

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
     * @param string $message Message
     * @param string $name    File name
     * @param string $level   Level
     *
     * @return void
     */
    public function log(
        $message,
        $name = self::DEFAULT_NAME,
        $level = self::LEVEL_INFO
    ) {
        $filePath = sprintf('%s/%s.log', FILES_ROOT . '/logs', $name);

        $isNew = false;
        if (file_exists($filePath) === false) {
            $isNew = true;
        }

        $logMessage = sprintf(
            '[%s] [%s] %s %s',
            date('Y-m-d H:i:s', time()),
            $level,
            $message,
            PHP_EOL . PHP_EOL
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
     * @param string $message Message
     * @param string $name    File name
     *
     * @return void
     */
    public function info($message, $name = self::DEFAULT_NAME)
    {
        $this->log($message, $name, self::LEVEL_INFO);
    }

    /**
     * Logs warning message
     *
     * @param string $message Message
     * @param string $name    File name
     *
     * @return void
     */
    public function warning($message, $name = self::DEFAULT_NAME)
    {
        $this->log($message, $name, self::LEVEL_WARNING);
    }

    /**
     * Logs error
     *
     * @param string $message Message
     * @param string $name    File name
     *
     * @return void
     */
    public function error($message, $name = self::DEFAULT_NAME)
    {
        $this->log($message, $name, self::LEVEL_ERROR);
    }

    /**
     * Logs debug message
     *
     * @param string $message Message
     * @param string $name    File name
     *
     * @return void
     */
    public function debug($message, $name = self::DEFAULT_NAME)
    {
        if (APP_ENV === ENV_DEV) {
            $this->log($message, $name, self::LEVEL_DEBUG);
        }
    }
}
