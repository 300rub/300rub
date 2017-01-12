<?php

namespace testS\models;

/**
 * Model for working with table "grids"
 *
 * @package testS\models
 */
class GridModel extends AbstractModel
{

    /**
     * Grid size
     */
    const GRID_SIZE = 12;

    /**
     * Default width
     */
    const DEFAULT_WIDTH = 3;

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "grids";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "blockId"    => [
                self::FIELD_RELATION => ["BlockModel", "blockModel"]
            ],
            "gridLineId" => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "x"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "max" => self::GRID_SIZE - 1,
                    "min" => 0
                ]
            ],
            "y"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "min" => 0
                ]
            ],
            "width"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "minThen" => [0, self::DEFAULT_WIDTH],
                    "max"     => [self::GRID_SIZE, "{x}", "-"]
                ],
            ],
        ];
    }
}