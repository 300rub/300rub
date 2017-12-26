<?php

namespace testS\models\system;

use testS\application\components\Db;
use testS\models\system\_abstract\AbstractSiteModel;

/**
 * Model for working with table "sites"
 */
class SiteModel extends AbstractSiteModel
{

    /**
     * Adds host condition to SQL request
     *
     * @param string $host Host name
     *
     * @return SiteModel
     */
    public function byHost($host)
    {
        $this->getDb()->addWhere(
            sprintf(
                '%s.host = :host',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('host', $host);

        return $this;
    }
}
