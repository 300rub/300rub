<?php

namespace ss\commands\_abstract;

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
}
