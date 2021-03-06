<?php

namespace ss\models\sections\_base;

use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "grids"
 */
abstract class AbstractGridModel extends AbstractModel
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
        return 'grids';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'blockId'    => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\blocks\\block\\BlockModel',
            ],
            'gridLineId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\ss\\models\\sections\\GridLineModel',
            ],
            'x'          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                    ValueGenerator::MAX => (self::GRID_SIZE - 1)
                ]
            ],
            'y'          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0
                ]
            ],
            'width'      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN_THEN => [0, self::DEFAULT_WIDTH],
                    ValueGenerator::MAX      => [self::GRID_SIZE, '{x}', '-']
                ],
            ],
        ];
    }
}
