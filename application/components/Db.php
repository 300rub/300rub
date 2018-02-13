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
    public function reset()
    {
        $this
            ->clearFields()
            ->clearParameters()
            ->clearWhere();

        return $this;
    }
}
