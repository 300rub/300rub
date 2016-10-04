<?php

namespace testS\applications;

use testS\commands\MigrateCommand;
use testS\components\Language;

/**
 * Class Test
 *
 * @package application
 */
class Test extends AbstractApplication
{

    /**
     * Runs application
     */
    public function run()
    {
        Language::$activeId = Language::LANGUAGE_EN_ID;
        MigrateCommand::loadFixtures();
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        MigrateCommand::loadFixtures();
    }
}