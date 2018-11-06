<?php

namespace ss\application\instances;

use ss\application\components\db\Db;
use ss\application\instances\_abstract\AbstractApplication;

/**
 * Selenium application class
 */
class Selenium extends AbstractApplication
{

    /**
     * Runs application
     *
     * @return void
     */
    public function run()
    {
        $hostname = sprintf(
            'selenium.%s',
            $this->getConfig()->getValue(['host'])
        );
        $this
            ->setSite($hostname)
            ->setActiveLanguage();

        $this->getDb()->setActivePdoKey(Db::CONFIG_DB_NAME_SELENIUM);
    }
}
