<?php

namespace ss\models\blocks\catalog\_base;

use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "catalogInstanceLinks"
 */
abstract class AbstractCatalogInstanceLinkModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'catalogInstanceLinks';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'catalogInstanceId'     => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\catalog\\CatalogInstanceModel',
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
                self::FIELD_SKIP_DUPLICATION     => true,
            ],
            'linkCatalogInstanceId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\catalog\\CatalogInstanceModel',
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
                self::FIELD_SKIP_DUPLICATION     => true,
            ],
        ];
    }
}
