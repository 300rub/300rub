<?php

namespace ss\commands\db\_abstract;

use ss\application\App;
use ss\commands\_abstract\AbstractCommand;

/**
 * Abstract DB command
 */
abstract class AbstractDbCommand extends AbstractCommand
{

    /**
     * Max attempts
     */
    const MAX_ATTEMPTS = 15;

    /**
     * Checks connection
     *
     * @param int $attempt Attempt
     *
     * @return bool
     */
    protected function checkConnection($attempt = 1)
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
            return $this->checkConnection($attempt + 1);
        }
    }
}
