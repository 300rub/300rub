<?php

namespace ss\tests\_abstract;

use ss\application\App;

/**
 * Abstract class to work with tests
 */
abstract class AbstractTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Sets up the fixture, for example, open a network connection.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
    }
}
