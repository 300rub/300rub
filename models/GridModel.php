<?php

namespace testS\models;

use testS\components\ValueGenerator;

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
                self::FIELD_RELATION => ["BlockModel"]
            ],
            "gridLineId" => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "x"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_MIN => 0,
                    ValueGenerator::TYPE_MAX => self::GRID_SIZE - 1
                ]
            ],
            "y"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_MIN => 0
                ]
            ],
            "width"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_MIN_THEN => [0, self::DEFAULT_WIDTH],
                    ValueGenerator::TYPE_MAX      => [self::GRID_SIZE, "{x}", "-"]
                ],
            ],
        ];
    }
}