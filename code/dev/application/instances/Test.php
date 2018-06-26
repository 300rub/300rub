<?php

namespace ss\application\instances;

use ss\application\instances\_abstract\AbstractApplication;

/**
 * Test application class
 */
class Test extends AbstractApplication
{

    /**
     * Runs application
     *
     * @return void
     */
    public function run()
    {
        $this->setSite();
    }
}