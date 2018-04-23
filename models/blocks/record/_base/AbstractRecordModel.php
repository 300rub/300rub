<?php

namespace ss\models\blocks\record\_base;

use ss\application\components\ValueGenerator;
use ss\models\blocks\_abstract\AbstractContentModel;

/**
 * Abstract model for working with table "records"
 */
abstract class AbstractRecordModel extends AbstractContentModel
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
    public function getDateTypeList()
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
        return 'records';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'coverImageId'     => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\image\\ImageModel'
            ],
            'imagesImageId'    => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\image\\ImageModel'
            ],
            'descriptionTextId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\TextModel'
            ],
            'textTextId'        => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\TextModel'
            ],
            'designRecordId'   => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\record\\DesignRecordModel'
            ],
            'hasCover'          => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            'hasImages'         => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            'hasCoverZoom'      => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            'hasDescription'    => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            'useAutoload'        => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
            'pageNavigationSize' => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            'shortCardDateType' => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        $this->getDateTypeList(),
                        self::DATE_TYPE_COMMON
                    ]
                ],
            ],
            'fullCardDateType'  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        $this->getDateTypeList(),
                        self::DATE_TYPE_COMMON
                    ]
                ],
            ],
        ];
    }
}
