<?php

namespace testS\models;

/**
 * Model for working with table "designSearch"
 *
 * @package testS\models
 */
class DesignSearchModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "designSearch";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "containerDesignBlockId"      => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "titleDesignBlockId"          => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "titleDesignTextId"           => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
            "descriptionDesignBlockId"    => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "descriptionDesignTextId"     => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
            "paginationDesignBlockId"     => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "paginationItemDesignBlockId" => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "paginationItemDesignTextId"  => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
        ];
    }
}