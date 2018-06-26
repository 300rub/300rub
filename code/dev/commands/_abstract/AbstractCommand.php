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
}
