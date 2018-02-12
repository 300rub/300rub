<?php

namespace testS\models\system;

use testS\application\components\Db;
use testS\models\system\_base\AbstractSiteModel;

/**
 * Model for working with table "sites"
 */
class SiteModel extends AbstractSiteModel
{

    /**
     * Adds name condition to SQL request
     *
     * @param string $name Name
     *
     * @return SiteModel
     */
    public function byName($name)
    {
        $this->getDb()->addWhere(
            sprintf(
                '%s.name = :name',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('name', $name);

        return $this;
    }

    /**
     * Adds domain condition to SQL request
     *
     * @param string $name Name
     *
     * @return SiteModel
     */
    public function byDomain($name)
    {
        $this->getDb()->addJoin(
            'domains',
            'domains',
            Db::DEFAULT_ALIAS,
            self::PK_FIELD,
            Db::JOIN_TYPE_INNER,
            'siteId'
        );

        $this->getDb()->addWhere('domains.name = :name');
        $this->getDb()->addParameter('name', $name);

        return $this;
    }
}
