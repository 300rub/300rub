<?php

namespace tests\unit;

use commands\MigrateCommand;
use PHPUnit_Framework_TestCase;

/**
 * Class AbstractUnitTest
 *
 * @package tests\unit
 */
abstract class AbstractUnitTest extends PHPUnit_Framework_TestCase
{

    /**
     * Called before the first test of the test case class is run
     */
    public static function setUpBeforeClass()
    {
        MigrateCommand::loadFixtures();
    }

    /**
     * Called after the last test of the test case class is run
     */
    public static function tearDownAfterClass()
    {
        MigrateCommand::loadFixtures();
    }
}