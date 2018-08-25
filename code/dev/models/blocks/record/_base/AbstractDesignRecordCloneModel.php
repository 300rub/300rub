<?php

namespace ss\models\blocks\record\_base;

use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "designRecordClones"
 */
abstract class AbstractDesignRecordCloneModel extends AbstractModel
{

    /**
     * View types
     */
    const VIEW_TYPE_LIST = 0;
    const VIEW_TYPE_GRID = 1;

    /**
     * Gets view type list
     *
     * @return array
     */
    public static function getViewTypeList()
    {
        return [
            self::VIEW_TYPE_LIST => '',
            self::VIEW_TYPE_GRID => '',
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'designRecordClones';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'containerDesignBlockId'   => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'instanceDesignBlockId'    => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'titleDesignBlockId'       => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'titleDesignTextId'        => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'dateDesignBlockId'         => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'dateDesignTextId'         => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'descriptionDesignBlockId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'descriptionDesignTextId'  => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\text\\DesignTextModel'
            ],
            'viewType'                 => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getViewTypeList(),
                        self::VIEW_TYPE_LIST
                    ]
                ],
            ],
        ];
    }
}
