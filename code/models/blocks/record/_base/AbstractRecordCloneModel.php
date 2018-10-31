<?php

namespace ss\models\blocks\record\_base;

use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\blocks\_abstract\AbstractContentModel;
use ss\application\components\helpers\DateTime;

/**
 * Abstract model for working with table "recordClones"
 */
abstract class AbstractRecordCloneModel extends AbstractContentModel
{

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
        $dateTime = new DateTime();

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
                        $dateTime->getFormatList(),
                        DateTime::TYPE_NONE
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
