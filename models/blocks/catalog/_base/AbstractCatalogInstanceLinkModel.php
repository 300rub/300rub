<?php

namespace testS\models\blocks\catalog\_base;

use testS\models\blocks\catalog\_abstract\AbstractCatalogModel;

/**
 * Abstract model for working with table "catalogInstanceLinks"
 */
abstract class AbstractCatalogInstanceLinkModel extends AbstractCatalogModel
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
                    => '\\testS\\models\\blocks\\catalog\\CatalogInstanceModel',
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
                self::FIELD_SKIP_DUPLICATION     => true,
            ],
            'linkCatalogInstanceId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\testS\\models\\blocks\\catalog\\CatalogInstanceModel',
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
                self::FIELD_SKIP_DUPLICATION     => true,
            ],
        ];
    }
}
