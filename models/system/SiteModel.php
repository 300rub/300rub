<?php

namespace ss\models\system;

use ss\application\App;
use ss\application\components\Db;
use ss\models\system\_base\AbstractSiteModel;

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

    /**
     * Gets internal host
     *
     * @return string
     */
    public function getInternalHost()
    {
        return sprintf(
            '%s.%s',
            $this->get('name'),
            App::getInstance()->getConfig()->getValue(['host'])
        );
    }

    /**
     * Gets main host
     *
     * @return string
     */
    public function getMainHost()
    {
        $domains = DomainModel::model()->getModelsBySiteId($this->getId());

        if (count($domains) > 0) {
            foreach ($domains as $domain) {
                if ($domain->get('isMain') === true) {
                    return $domain->get('name');
                }
            }

            foreach ($domains as $domain) {
                return $domain->get('name');
            }
        }

        return $this->getInternalHost();
    }
}
