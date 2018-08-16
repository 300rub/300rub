<?php

namespace ss\commands\db;

use ss\application\App;
use ss\commands\db\_abstract\AbstractDbCommand;
use ss\migrations\M160302000000Migrations;

/**
 * Clear DB command
 */
class RecreateSeleniumDatabaseCommand extends AbstractDbCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $config = App::getInstance()->getConfig();

        $this->checkConnection();

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s -e "DROP DATABASE IF EXISTS %s"',
                $config->getValue(['db', 'selenium', 'password']),
                $config->getValue(['db', 'selenium', 'user']),
                $config->getValue(['db', 'selenium', 'host']),
                $config->getValue(['db', 'selenium', 'name'])
            )
        );
        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s -e "CREATE DATABASE %s"',
                $config->getValue(['db', 'selenium', 'password']),
                $config->getValue(['db', 'selenium', 'user']),
                $config->getValue(['db', 'selenium', 'host']),
                $config->getValue(['db', 'selenium', 'name'])
            )
        );

        App::getInstance()->getDb()->setPdo(
            $config->getValue(['db', 'selenium', 'host']),
            $config->getValue(['db', 'selenium', 'user']),
            $config->getValue(['db', 'selenium', 'password']),
            $config->getValue(['db', 'selenium', 'name'])
        );

        $migration = new M160302000000Migrations();
        $migration->apply();
    }
}
