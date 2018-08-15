<?php

namespace ss\application\components;

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
     * @param string $host     Host
     * @param string $user     User
     * @param string $password Password
     * @param string $name     DB name
     *
     * @return Db
     */
    public function createNewDb($host, $user, $password, $name)
    {
        $this->setRootPdo($host);

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
}
