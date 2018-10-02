<?php

namespace ss\models\blocks\record\_base;

use ss\application\components\helpers\DateTime;
use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\blocks\_abstract\AbstractContentModel;

/**
 * Abstract model for working with table "records"
 */
abstract class AbstractRecordModel extends AbstractContentModel
{

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
        $dateTime = new DateTime();

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
                        $dateTime->getFormatList(),
                        DateTime::TYPE_NONE
                    ]
                ],
            ],
            'fullCardDateType'  => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        $dateTime->getFormatList(),
                        DateTime::TYPE_NONE
                    ]
                ],
            ],
        ];
    }
}
