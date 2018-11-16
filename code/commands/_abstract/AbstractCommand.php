<?php

namespace ss\commands\_abstract;

use ss\application\exceptions\CommonException;

/**
 * Abstract command class
 */
abstract class AbstractCommand
{

    /**
     * Arguments
     *
     * @var string[]
     */
    protected $args = [];

    /**
     * Runs command
     *
     * @return void
     */
    abstract public function run();

    /**
     * Sets arguments
     *
     * @param string[] $args Arguments
     *
     * @return AbstractCommand
     */
    public function setArguments($args)
    {
        $this->args = $args;
        return $this;
    }

    /**
     * Checks if env is DEV
     *
     * @throws CommonException
     *
     * @return void
     */
    protected function checkIsDev()
    {
        if (APP_ENV !== ENV_DEV) {
            throw new CommonException(
                'Unable to run command because env is {env}',
                [
                    'env' => APP_ENV
                ]
            );
        }
    }

    /**
     * Gets arg by key
     *
     * @param int $key Arg key
     *
     * @return string
     */
    protected function getArg($key)
    {
        if (array_key_exists($key, $this->args) === true) {
            return $this->args[$key];
        }

        return null;
    }

    /**
     * Outputs text
     *
     * @param string $text       Text
     * @param bool   $isSameLine Is the same line
     *
     * @return AbstractCommand
     */
    protected function output($text, $isSameLine = null)
    {
        $prefix = PHP_EOL;
        if ($isSameLine === true) {
            $prefix = '';
        }

        echo sprintf(
            '%s%s ',
            $prefix,
            $text
        );

        return $this;
    }
}
