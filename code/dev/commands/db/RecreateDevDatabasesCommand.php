<?php

namespace ss\commands\db;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;
use ss\migrations\M160301000000Sites;
use ss\migrations\M160301000010Domains;
use ss\migrations\M160301000020Help;
use ss\migrations\M160302000000Migrations;

/**
 * Clear DB command
 */
class RecreateDevDatabasesCommand extends AbstractCommand
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
        $this->checkIsDev();
        $this->_checkConnection();

        $config = App::getInstance()->getConfig();
        $dbObject = App::getInstance()->getDb();
        $dbHost = $dbObject->getRandomDbHost();

        $dbObject
            ->dropDb(
                $dbHost,
                'sys'
            )
            ->createNewDb(
                $dbHost,
                $config->getValue(['db', 'dev', 'user']),
                $config->getValue(['db', 'dev', 'password']),
                $config->getValue(['db', 'dev', 'name']),
                true
            )
            ->createNewDb(
                $dbHost,
                $config->getValue(['db', 'system', 'user']),
                $config->getValue(['db', 'system', 'password']),
                $config->getValue(['db', 'system', 'name']),
                true
            )
            ->createNewDb(
                $dbHost,
                $config->getValue(['db', 'help', 'user']),
                $config->getValue(['db', 'help', 'password']),
                $config->getValue(['db', 'help', 'name']),
                true
            );

        $dbObject = App::getInstance()->getDb();

        $dbObject->setSystemPdo();

        $migration = new M160301000000Sites();
        $migration->apply();

        $migration = new M160301000010Domains();
        $migration->apply();

        $dbObject->setPdo(
            $config->getValue(['db', 'help', 'host']),
            $config->getValue(['db', 'help', 'user']),
            $config->getValue(['db', 'help', 'password']),
            $config->getValue(['db', 'help', 'name'])
        );

        $migration = new M160301000020Help();
        $migration->apply();

        $dbObject->setPdo(
            $config->getValue(['db', 'dev', 'host']),
            $config->getValue(['db', 'dev', 'user']),
            $config->getValue(['db', 'dev', 'password']),
            $config->getValue(['db', 'dev', 'name'])
        );

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
        $dbHost = App::getInstance()->getDb()->getRandomDbHost();

        try {
            $conn = new \PDO(
                sprintf(
                    'mysql:host=%s;',
                    $dbHost
                ),
                $config->getValue(['db', 'root', $dbHost, 'user']),
                $config->getValue(['db', 'root', $dbHost, 'password'])
            );

            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (\Exception $e) {
            sleep(1);
            return $this->_checkConnection($attempt + 1);
        }
    }
}
