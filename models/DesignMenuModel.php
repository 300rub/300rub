<?php

namespace testS\models;

/**
 * Model for working with table "designMenu"
 *
 * @package testS\models
 */
class DesignMenuModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "designMenu";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "containerDesignBlockId"       => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "firstLevelDesignBlockId"       => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "firstLevelDesignTextId"       => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
            "secondLevelDesignBlockId"       => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "secondLevelDesignTextId"       => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
            "lastLevelDesignBlockId"       => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "lastLevelDesignTextId"       => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
        ];
    }
}