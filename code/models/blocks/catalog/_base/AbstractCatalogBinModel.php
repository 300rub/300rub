<?php

namespace ss\models\blocks\catalog\_base;

use ss\application\components\common\Validator;

use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "catalogBins"
 */
abstract class AbstractCatalogBinModel extends AbstractModel
{

    /**
     * Statuses
     */
    const STATUS_ADDED = 0;
    const STATUS_COMPLETED = 1;

    /**
     * Gets a status list
     *
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_ADDED     => '',
            self::STATUS_COMPLETED => '',
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'catalogBins';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'catalogId'         => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\catalog\\CatalogModel',
                self::FIELD_SKIP_DUPLICATION     => true,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            'catalogInstanceId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\catalog\\CatalogInstanceModel',
                self::FIELD_SKIP_DUPLICATION     => true,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            'count'             => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALIDATION       => [
                    Validator::TYPE_MIN_VALUE => 1
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'status'            => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getStatusList(),
                        self::STATUS_ADDED
                    ]
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }
}
