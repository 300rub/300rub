<?php

namespace ss\commands\db;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;
use ss\migrations\M160302000000Migrations;

/**
 * Clear DB command
 */
class RecreateTestDatabaseCommand extends AbstractCommand
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
                $config->getValue(['db', 'phpunitTest', 'password']),
                $config->getValue(['db', 'phpunitTest', 'user']),
                $config->getValue(['db', 'phpunitTest', 'host']),
                $config->getValue(['db', 'phpunitTest', 'name'])
            )
        );
        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s -e "CREATE DATABASE %s"',
                $config->getValue(['db', 'phpunitTest', 'password']),
                $config->getValue(['db', 'phpunitTest', 'user']),
                $config->getValue(['db', 'phpunitTest', 'host']),
                $config->getValue(['db', 'phpunitTest', 'name'])
            )
        );

        App::getInstance()->getDb()->setTestPdo();

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
                    'mysql:host=%s;',
                    $config->getValue(['db', 'phpunitTest', 'host'])
                ),
                $config->getValue(['db', 'phpunitTest', 'user']),
                $config->getValue(['db', 'phpunitTest', 'password'])
            );

            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (\Exception $e) {
            sleep(1);
            return $this->_checkConnection($attempt + 1);
        }
    }
}
