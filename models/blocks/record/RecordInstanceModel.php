<?php

namespace ss\models\blocks\record;

use ss\application\components\Db;
use ss\models\blocks\record\_base\AbstractRecordInstanceModel;

/**
 * Model for working with table "recordInstances"
 */
class RecordInstanceModel extends AbstractRecordInstanceModel
{

    /**
     * Gets new model
     *
     * @return RecordInstanceModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Find by URL
     *
     * @param string $url URL
     *
     * @return RecordInstanceModel
     */
    public function byUrl($url)
    {
        $this->getDb()->addJoin(
            'seo',
            'seo',
            Db::DEFAULT_ALIAS,
            'seoId'
        );

        $this->getDb()->addWhere(
            'seo.url = :url'
        );
        $this->getDb()->addParameter('url', $url);

        return $this;
    }

    /**
     * Adds recordId condition to SQL request
     *
     * @param int $recordId Record ID
     *
     * @return RecordInstanceModel
     */
    public function byRecordId($recordId)
    {
        $this->getDb()->addWhere(
            sprintf(
                '%s.recordId = :recordId',
                Db::DEFAULT_ALIAS
            )
        );
        $this->getDb()->addParameter('recordId', (int)$recordId);

        return $this;
    }
}
