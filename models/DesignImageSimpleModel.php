<?php

namespace testS\models;

/**
 * Model for working with table "designImageSimples"
 *
 * @package testS\models
 */
class DesignImageSimpleModel extends AbstractDesignModel
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
        return "designImageSimples";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "designBlockId"      => [
                self::FIELD_RELATION => ["DesignBlockModel", "designBlockModel"]
            ],
            "imageDesignBlockId" => [
                self::FIELD_RELATION => ["DesignBlockModel", "imageDesignBlockModel"]
            ],
            "designTextId"       => [
                self::FIELD_RELATION => ["DesignTextModel", "designTextModel"]
            ],
            "alignment"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "arrayKey" => [self::getAlignmentList(), self::ALIGNMENT_LEFT]
                ],
            ]
        ];
    }

    /**
     * Gets values for object
     *
     * @param string $name Object name
     *
     * @return array
     */
    public function getValues($name)
    {
        $this
            ->setDesignValue("imageSimple", "alignment", "alignment", $name);

        return $this->designValues;
    }
}