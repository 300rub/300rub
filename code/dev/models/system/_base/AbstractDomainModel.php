<?php

namespace ss\models\system\_base;

use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "domains"
 */
abstract class AbstractDomainModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'domains';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'siteId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\system\\SiteModel'
            ],
            'name'   => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
            ],
            'isMain' => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
        ];
    }
}
