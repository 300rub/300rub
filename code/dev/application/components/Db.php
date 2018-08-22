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
     * Admin postfix
     */
    const ADMIN_POSTFIX = 'Admin';

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
     * Gets admin DB name
     *
     * @param string $dbName DB name
     *
     * @return string
     */
    public function getAdminDbName($dbName)
    {
        return $dbName . self::ADMIN_POSTFIX;
    }
}
