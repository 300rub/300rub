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
        Language::setActiveId(Language::LANGUAGE_EN_ID);

        //session_id("aaa");
        session_start();
       // $_SESSION["aa"] = "bb";
        var_dump($_SESSION);
        var_dump(strlen(session_id()));
    }
}