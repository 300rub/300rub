<?php

namespace testS\models;

use testS\components\ValueGenerator;

/**
 * Model for working with table "designImageSimple"
 *
 * @package testS\models
 */
class DesignImageSimpleModel extends AbstractModel
{

    /**
     * Alignments
     */
    const ALIGNMENT_LEFT = 0;
    const ALIGNMENT_CENTER = 1;
    const ALIGNMENT_RIGHT = 2;

    /**
     * Gets alignment list
     *
     * @return array
     */
    public static function getAlignmentList()
    {
        return [
            self::ALIGNMENT_LEFT   => "",
            self::ALIGNMENT_CENTER => "",
            self::ALIGNMENT_RIGHT  => ""
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "designImageSimple";
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
            "imageDesignBlockId" => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "designTextId"       => [
                self::FIELD_RELATION => "DesignTextModel"
            ],
            "alignment"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::TYPE_ARRAY_KEY => [self::getAlignmentList(), self::ALIGNMENT_LEFT]
                ],
            ]
        ];
    }
}