<?php

namespace testS\application\instances;

use testS\application\instances\_abstract\AbstractApplication;

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
        $this->setSite(DEV_HOST);
    }
}
