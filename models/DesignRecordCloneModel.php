<?php

namespace testS\models;

use testS\components\ValueGenerator;

/**
 * Model for working with table "designRecordClones"
 *
 * @package testS\models
 */
class DesignRecordCloneModel extends AbstractModel
{

    /**
     * View types
     */
    const VIEW_TYPE_LIST = 0;

    /**
     * Gets view type list
     *
     * @return array
     */
    public static function getViewTypeList()
    {
        return [
            self::VIEW_TYPE_LIST => ""
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "designRecordClones";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "containerDesignBlockId"   => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "instanceDesignBlockId"    => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "titleDesignBlockId"       => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "titleDesignTextId"        => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
            "dateDesignTextId"         => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
            "descriptionDesignBlockId" => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "descriptionDesignTextId"  => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
            "viewType"                 => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_ARRAY_KEY => [
                        self::getViewTypeList(),
                        self::VIEW_TYPE_LIST
                    ]
                ],
            ],
        ];
    }
}