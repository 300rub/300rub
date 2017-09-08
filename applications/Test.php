<?php

namespace testS\applications;

use testS\components\Db;
use testS\components\Language;

/**
 * Class Test
 *
 * @package testS\application
 */
class Test extends AbstractApplication
{

    /**
     * Runs application
     */
    public function run()
    {
        $this->setSite();
    }
}