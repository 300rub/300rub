<?php

namespace testS\applications;

/**
 * Class for working with WEB application
 *
 * @package testS\application
 */
class Web extends AbstractApplication
{
    /**
     * Runs application
     *
     * @return void
     */
    public function run()
    {
        echo 123;
        echo $_SERVER['REQUEST_METHOD'];
    }
}