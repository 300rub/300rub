<?php

namespace ss\application\components;

use ss\application\App;
use ss\application\components\_abstract\AbstractDbWrite;

/**
 * Class for working with DB
 */
class Db extends AbstractDbWrite
{

    /**
     * Resets fields and parameters
     *
     * @return Db
     */
    protected function reset()
    {
        $this
            ->clearFields()
            ->resetSelect()
            ->setOrder('')
            ->setLimit('')
            ->setWhere('')
            ->resetJoin()
            ->clearParameters();

        return $this;
    }

    /**
     * Creates DB
     *
     * @param string $host       Host
     * @param string $user       User
     * @param string $password   Password
     * @param string $name       DB name
     * @param string $isRecreate Flag to recreate
     *
     * @return Db
     */
    public function createNewDb(
        $host,
        $user,
        $password,
        $name,
        $isRecreate = null
    ) {
        $this->setRootPdo($host);

        if ($isRecreate === true) {
            $this->dropDb($host, $name);
        }

        $statement = sprintf(
            "CREATE DATABASE IF NOT EXISTS %s",
            $name
        );
        $this->execute($statement);

        $statement = sprintf(
            "GRANT ALL ON `%s`.* TO '%s'@'%s' IDENTIFIED BY '%s'",
            $name,
            $user,
            $host,
            $password
        );
        $this->execute($statement);

        return $this;
    }

    /**
     * Creates DB
     *
     * @param string $host Host
     * @param string $name DB name
     *
     * @return Db
     */
    public function dropDb($host, $name) {
        $this->setRootPdo($host);

        $statement = sprintf(
            "DROP DATABASE IF EXISTS %s",
            $name
        );
        $this->execute($statement);

        return $this;
    }

    /**
     * Gets random DB host
     *
     * @return string
     */
    public function getRandomDbHost()
    {
        $hosts = array_keys(
            App::getInstance()->getConfig()->getValue(['db', 'root'])
        );
        shuffle($hosts);

        return $hosts[0];
    }
}
