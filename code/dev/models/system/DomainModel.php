<?php

namespace ss\models\system;


use ss\models\system\_base\AbstractDomainModel;

/**
 * Model for working with table "domains"
 */
class DomainModel extends AbstractDomainModel
{

    /**
     * Adds name condition to SQL request to select by site ID
     *
     * @param string $siteId Site ID
     *
     * @return DomainModel
     */
    public function bySiteId($siteId)
    {
        $this->getDb()->addWhere(
            sprintf(
                '%s.siteId = :siteId',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('siteId', $siteId);

        return $this;
    }

    /**
     * Returns DomainModel
     *
     * @return DomainModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Gets models by site ID
     *
     * @param integer $siteId Site ID
     *
     * @return DomainModel[]
     */
    public function getModelsBySiteId($siteId)
    {
        return $this
            ->bySiteId($siteId)
            ->findAll();
    }
}
