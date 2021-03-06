<?php

namespace ss\models\blocks\catalog\_base;

use ss\application\components\common\Validator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "catalogOrders"
 */
abstract class AbstractCatalogOrderModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'catalogOrders';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'catalogBinId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\catalog\\CatalogBinModel',
                self::FIELD_SKIP_DUPLICATION     => true,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            'formId'       => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\helpers\\form\\FormModel',
                self::FIELD_SKIP_DUPLICATION     => true,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            'email'        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_EMAIL
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }
}
