<?php

namespace testS\models\blocks\record\_base;

use testS\application\components\ValueGenerator;
use testS\models\blocks\record\_abstract\AbstractRecordModel;

/**
 * Abstract model for working with table "designRecordClones"
 */
abstract class AbstractDesignRecordCloneModel extends AbstractRecordModel
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
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'instanceDesignBlockId'    => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'titleDesignBlockId'       => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'titleDesignTextId'        => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'dateDesignTextId'         => [
                self::FIELD_RELATION => 'DesignTextModel'
            ],
            'descriptionDesignBlockId' => [
                self::FIELD_RELATION => 'DesignBlockModel'
            ],
            'descriptionDesignTextId'  => [
                self::FIELD_RELATION => 'DesignTextModel'
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
