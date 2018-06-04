<?php

namespace ss\commands;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;
use ss\migrations\M160301000000Sites;
use ss\migrations\M160301000010Domains;
use ss\migrations\M160302000000Migrations;

/**
 * Clear DB command
 */
class ClearDbCommand extends AbstractCommand
{

    /**
     * Max attempts
     */
    const MAX_ATTEMPTS = 15;

    /**
     * Runs the command
     *
     * @return void
     */
    public function run()
    {
        $config = App::getInstance()->getConfig();

        $this->_checkConnection();

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s -e "DROP DATABASE IF EXISTS %s"',
                $config->getValue(['db', 'site1', 'password']),
                $config->getValue(['db', 'site1', 'user']),
                $config->getValue(['db', 'site1', 'host']),
                $config->getValue(['db', 'site1', 'name'])
            )
        );
        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s -e "CREATE DATABASE %s"',
                $config->getValue(['db', 'site1', 'password']),
                $config->getValue(['db', 'site1', 'user']),
                $config->getValue(['db', 'site1', 'host']),
                $config->getValue(['db', 'site1', 'name'])
            )
        );

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s -e "DROP DATABASE IF EXISTS %s"',
                $config->getValue(['db', 'site2', 'password']),
                $config->getValue(['db', 'site2', 'user']),
                $config->getValue(['db', 'site2', 'host']),
                $config->getValue(['db', 'site2', 'name'])
            )
        );
        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s -e "CREATE DATABASE IF NOT EXISTS %s"',
                $config->getValue(['db', 'site2', 'password']),
                $config->getValue(['db', 'site2', 'user']),
                $config->getValue(['db', 'site2', 'host']),
                $config->getValue(['db', 'site2', 'name'])
            )
        );

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s -e "DROP DATABASE IF EXISTS %s"',
                $config->getValue(['db', 'system', 'password']),
                $config->getValue(['db', 'system', 'user']),
                $config->getValue(['db', 'system', 'host']),
                $config->getValue(['db', 'system', 'name'])
            )
        );
        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s -e "CREATE DATABASE IF NOT EXISTS %s"',
                $config->getValue(['db', 'system', 'password']),
                $config->getValue(['db', 'system', 'user']),
                $config->getValue(['db', 'system', 'host']),
                $config->getValue(['db', 'system', 'name'])
            )
        );

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s -e "DROP DATABASE IF EXISTS %s"',
                $config->getValue(['db', 'help', 'password']),
                $config->getValue(['db', 'help', 'user']),
                $config->getValue(['db', 'help', 'host']),
                $config->getValue(['db', 'help', 'name'])
            )
        );
        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s -e "CREATE DATABASE IF NOT EXISTS %s"',
                $config->getValue(['db', 'help', 'password']),
                $config->getValue(['db', 'help', 'user']),
                $config->getValue(['db', 'help', 'host']),
                $config->getValue(['db', 'help', 'name'])
            )
        );

        App::getInstance()->getDb()->setSystemPdo();

        $migration = new M160301000000Sites();
        $migration->apply();
        $migration->insertData();

        $migration = new M160301000010Domains();
        $migration->apply();
        $migration->insertData();

        $migration = new M160302000000Migrations();
        $migration->apply();
    }

    /**
     * Checks connection
     *
     * @param int $attempt Attempt
     *
     * @return bool
     */
    private function _checkConnection($attempt = 1)
    {
        if ($attempt > self::MAX_ATTEMPTS) {
            return false;
        }

        $config = App::getInstance()->getConfig();

        try {
            $conn = new \PDO(
                sprintf(
                    "mysql:host=%s;",
                    $config->getValue(['db', 'site1', 'host'])
                ),
                $config->getValue(['db', 'site1', 'user']),
                $config->getValue(['db', 'site1', 'password'])
            );

            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (\Exception $e) {
            sleep(1);
            return $this->_checkConnection($attempt + 1);
        }
    }
}
