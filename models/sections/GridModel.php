<?php

namespace testS\models;

use testS\components\ValueGenerator;

/**
 * Model for working with table "grids"
 *
 * @method GridModel   in($field, $values)
 * @method GridModel   ordered($value)
 * @method GridModel[] findAll()
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
                self::FIELD_RELATION_TO_PARENT => "BlockModel",
            ],
            "gridLineId" => [
                self::FIELD_RELATION_TO_PARENT => "GridLineModel",
            ],
            "x"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => self::GRID_SIZE - 1
                ]
            ],
            "y"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ]
            ],
            "width"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN_THEN => [0, self::DEFAULT_WIDTH],
                    ValueGenerator::MAX      => [self::GRID_SIZE, "{x}", "-"]
                ],
            ],
        ];
    }
}