<?php

namespace ss\models\blocks\record\_base;

use ss\application\components\ValueGenerator;
use ss\models\blocks\_abstract\AbstractContentModel;

/**
 * Abstract model for working with table "recordClones"
 */
abstract class AbstractRecordCloneModel extends AbstractContentModel
{

    /**
     * Short date types
     */
    const DATE_TYPE_COMMON = 0;
    const DATE_TYPE_1 = 1;

    /**
     * Gets date type list
     *
     * @return array
     */
    public static function getDateTypeList()
    {
        return [
            self::DATE_TYPE_COMMON => '',
            self::DATE_TYPE_1      => '',
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'recordClones';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'recordId'            => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\record\\RecordModel'
            ],
            'coverImageId'       => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\image\\ImageModel'
            ],
            'descriptionTextId'   => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\TextModel'
            ],
            'designRecordCloneId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\record\\DesignRecordCloneModel'
            ],
            'hasCover'            => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            'hasCoverZoom'        => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            'hasDescription'      => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            'dateType'            => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getDateTypeList(),
                        self::DATE_TYPE_COMMON
                    ]
                ],
            ],
            'maxCount'            => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ],
            ]
        ];
    }
}
