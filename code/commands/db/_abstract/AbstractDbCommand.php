<?php

namespace ss\commands\db\_abstract;

use ss\application\App;
use ss\application\exceptions\DbException;
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
     * @return AbstractDbCommand
     *
     * @throws DbException
     */
    protected function checkConnection($attempt = 1)
    {
        $config = App::getInstance()->getConfig();
        $dbHost = App::getInstance()->getDb()->getRandomDbHost();

        if ($attempt > self::MAX_ATTEMPTS) {
            throw new DbException(
                'Unable to connect to BD host: {host}',
                [
                    'host' => $dbHost,
                ]
            );
        }

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
        } catch (\Exception $e) {
            sleep(1);
            $this->checkConnection($attempt + 1);
        }

        return $this;
    }
}
