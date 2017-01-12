<?php

namespace testS\models;

/**
 * Model for working with table "gridLines"
 *
 * @package testS\models
 */
class GridLineModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "gridLines";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "sectionId"       => [
                self::FIELD_RELATION_TO_PARENT => "SectionModel",
            ],
            "outsideDesignId" => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "insideDesignId"  => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "sort"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
        ];
    }
}