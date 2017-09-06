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
        Language::setActiveId(Language::LANGUAGE_EN_ID);
        Db::setPdo(
            $this->getConfig(["db", "localhost", "host"]),
            $this->getConfig(["db", "localhost", "user"]),
            $this->getConfig(["db", "localhost", "password"]),
            $this->getConfig(["db", "localhost", "name"])
        );
    }
}