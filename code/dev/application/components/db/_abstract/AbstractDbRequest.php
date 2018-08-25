<?php

namespace ss\application\components\db\_abstract;

use ss\application\App;
use ss\application\exceptions\DbException;

/**
 * Abstract class to work with DB requests
 */
abstract class AbstractDbRequest extends AbstractDbTransaction
{

    /**
     * Path to source dump
     */
    const SOURCE_PATH = CODE_ROOT . '/config/db/source.sql';

    /**
     * Creates DB
     *
     * @param string $host       Host
     * @param string $user       User
     * @param string $password   Password
     * @param string $dbName     DB name
     * @param string $isRecreate Flag to recreate
     *
     * @return AbstractDbRequest
     *
     * @throws DbException
     */
    public function createDb(
        $host,
        $user,
        $password,
        $dbName,
        $isRecreate = null
    ) {
        if ($isRecreate === true) {
            $this->dropDb($host, $dbName);
        }

        $this->setRootPdo($host);

        $this->execute(
            sprintf(
                'CREATE DATABASE IF NOT EXISTS %s',
                $dbName
            )
        );

        $this->execute(
            sprintf(
                "GRANT ALL ON `%s`.* TO '%s'@'%s' IDENTIFIED BY '%s'",
                $dbName,
                $user,
                $host,
                $password
            )
        );

        return $this;
    }

    /**
     * Drops DB
     *
     * @param string $host   Host
     * @param string $dbName DB name
     *
     * @return AbstractDbRequest
     *
     * @throws DbException
     */
    public function dropDb($host, $dbName)
    {
        $this
            ->setRootPdo($host)
            ->execute(
                sprintf(
                    'DROP DATABASE IF EXISTS %s',
                    $dbName
                )
            );

        return $this;
    }

    /**
     * Gets all databases
     *
     * @param string $host Host
     *
     * @return string[]
     *
     * @throws DbException
     */
    public function getAllDbNames($host)
    {
        $sth = $this
            ->setRootPdo($host)
            ->execute('SHOW DATABASES');

        $list = [];

        $results = $sth->fetchAll();
        foreach ($results as $item) {
            $list[] = $item['Database'];
        }

        return $list;
    }

    /**
     * Gets DB name for writing
     *
     * @param string $initialDbName Initial DB name
     *
     * @return string
     */
    public function getWriteDbName($initialDbName)
    {
        if ($initialDbName === self::CONFIG_DB_NAME_HELP
            || $initialDbName === self::CONFIG_DB_NAME_SYSTEM
            || $initialDbName === self::CONFIG_DB_NAME_SOURCE
        ) {
            return $initialDbName;
        }

        return $initialDbName . self::NAME_POSTFIX_WRITE;
    }

    /**
     * Gets DB name for reading
     *
     * @param string $initialDbName Initial DB name
     *
     * @return string
     */
    public function getReadDbName($initialDbName)
    {
        if ($initialDbName === self::CONFIG_DB_NAME_HELP
            || $initialDbName === self::CONFIG_DB_NAME_SYSTEM
            || $initialDbName === self::CONFIG_DB_NAME_SOURCE
        ) {
            return $initialDbName;
        }

        return $initialDbName . self::NAME_POSTFIX_READ;
    }

    /**
     * Exports DB
     *
     * @param string $host   Host
     * @param string $dbName DB name
     * @param string $path   Path
     *
     * @return AbstractDbRequest
     */
    public function exportDb($host, $dbName, $path = null)
    {
        $rootUser = App::getInstance()
            ->getConfig()
            ->getValue(['db', 'root', $host]);

        if ($path === null) {
            $path = sprintf(
                '%s/backups/%s.sql',
                FILES_ROOT,
                $dbName
            );
        }

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysqldump -u %s -h %s %s > %s',
                $rootUser['password'],
                $rootUser['user'],
                $host,
                $dbName,
                $path
            )
        );

        return $this;
    }

    /**
     * Exports DB
     *
     * @param string $host   Host
     * @param string $dbName DB name
     * @param string $path   Path
     *
     * @return AbstractDbRequest
     *
     * @throws DbException
     */
    public function importDb($host, $dbName, $path = null)
    {
        $rootUser = App::getInstance()
            ->getConfig()
            ->getValue(['db', 'root', $host]);

        if ($path === null) {
            $path = sprintf(
                '%s/backups/%s.sql',
                FILES_ROOT,
                $dbName
            );
        }

        if (file_exists($path) === false) {
            throw new DbException(
                'Unable to find the dump file with path: {path}',
                [
                    'path' => $path
                ]
            );
        }

        exec(
            sprintf(
                'export MYSQL_PWD=%s; ' .
                'mysql -u %s -h %s %s < %s',
                $rootUser['password'],
                $rootUser['user'],
                $host,
                $dbName,
                $path
            )
        );

        return $this;
    }

    /**
     * Executes statement
     *
     * @param string $statement  Statement
     * @param array  $parameters Parameters
     *
     * @throws DbException
     *
     * @return \PDOStatement
     */
    public function execute($statement, array $parameters = [])
    {
        $sth = $this->getActivePdo()->prepare($statement);
        $result = $sth->execute($parameters);

        if ($result === false) {
            throw new DbException(
                'Unable to execute statement: {statement} ' .
                'with parameters: {parameters}',
                [
                    'statement'  => $statement,
                    'parameters' => json_encode($parameters),
                ]
            );
        }

        return $sth;
    }
}
