<?php

namespace testS\applications;

use testS\commands\CreateSqlDumpsCommand;
use testS\commands\RollbackSqlDumpsCommand;
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
        Language::$activeId = Language::LANGUAGE_EN_ID;
    }
}