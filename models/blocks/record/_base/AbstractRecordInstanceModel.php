<?php

namespace testS\models\blocks\record\_base;

use testS\models\blocks\record\_abstract\AbstractRecordModel;

/**
 * Abstract model for working with table "recordInstances"
 */
abstract class AbstractRecordInstanceModel extends AbstractRecordModel
{

    /**
     * Short date types
     */
    const DATE_TYPE_COMMON = 0;

    /**
     * Gets date type list
     *
     * @return array
     */
    public static function getDateTypeList()
    {
        return [
            self::DATE_TYPE_COMMON => ''
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'recordInstances';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'recordId'                  => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\testS\\models\\blocks\\record\\RecordModel',
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'seoId'                     => [
                self::FIELD_RELATION
                    => '\\testS\\models\\sections\\SeoModel',
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'textTextInstanceId'        => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\text\\TextInstanceModel',
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'descriptionTextInstanceId' => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\text\\TextInstanceModel',
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'imageGroupId'              => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\image\\ImageGroupModel',
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'coverImageInstanceId'      => [
                self::FIELD_RELATION
                    => '\\testS\\models\\blocks\\image\\ImageInstanceModel',
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'date'                      => [
                self::FIELD_TYPE => self::FIELD_TYPE_DATETIME,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'sort'                      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }
}
