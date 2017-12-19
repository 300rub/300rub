<?php

namespace testS\commands;

use testS\application\App;
use testS\commands\_abstract\AbstractCommand;
use testS\migrations\M160301000000Sites;
use testS\migrations\M160302000000Migrations;

/**
 * Clear DB command
 */
class ClearDbCommand extends AbstractCommand
{

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $config = App::getInstance()->getConfig();

        exec(
            sprintf(
                'mysql -u %s -p%s -h %s -e "DROP DATABASE IF EXISTS %s"',
                $config->getValue(['db', 'localhost', 'user']),
                $config->getValue(['db', 'localhost', 'password']),
                $config->getValue(['db', 'localhost', 'host']),
                $config->getValue(['db', 'localhost', 'name'])
            )
        );
        exec(
            sprintf(
                'mysql -u %s -p%s -h %s -e "CREATE DATABASE IF NOT EXISTS %s"',
                $config->getValue(['db', 'localhost', 'user']),
                $config->getValue(['db', 'localhost', 'password']),
                $config->getValue(['db', 'localhost', 'host']),
                $config->getValue(['db', 'localhost', 'name'])
            )
        );

        exec(
            sprintf(
                'mysql -u %s -p%s -h %s -e "DROP DATABASE IF EXISTS %s"',
                $config->getValue(['db', 'system', 'user']),
                $config->getValue(['db', 'system', 'password']),
                $config->getValue(['db', 'system', 'host']),
                $config->getValue(['db', 'system', 'name'])
            )
        );
        exec(
            sprintf(
                'mysql -u %s -p%s -h %s -e "CREATE DATABASE IF NOT EXISTS %s"',
                $config->getValue(['db', 'system', 'user']),
                $config->getValue(['db', 'system', 'password']),
                $config->getValue(['db', 'system', 'host']),
                $config->getValue(['db', 'system', 'name'])
            )
        );

        exec(
            sprintf(
                'mysql -u %s -p%s -h %s -e "DROP DATABASE IF EXISTS %s"',
                $config->getValue(['db', 'help', 'user']),
                $config->getValue(['db', 'help', 'password']),
                $config->getValue(['db', 'help', 'host']),
                $config->getValue(['db', 'help', 'name'])
            )
        );
        exec(
            sprintf(
                'mysql -u %s -p%s -h %s -e "CREATE DATABASE IF NOT EXISTS %s"',
                $config->getValue(['db', 'help', 'user']),
                $config->getValue(['db', 'help', 'password']),
                $config->getValue(['db', 'help', 'host']),
                $config->getValue(['db', 'help', 'name'])
            )
        );

        App::getInstance()->getDb()->setSystemPdo();

        $migration = new M160301000000Sites();
        $migration->apply();
        $migration->insertData();

        $migration = new M160302000000Migrations();
        $migration->apply();
    }
}
