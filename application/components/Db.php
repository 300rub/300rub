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
}
