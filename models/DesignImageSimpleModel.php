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
     * Gets model object
     *
     * @return DesignImageSimpleModel
     */
    public static function model()
    {
        $className = __CLASS__;
        return new $className;
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
    protected function getFieldsInfo()
    {
        return [
            "alignment"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setAlignment"]
            ],
            "designBlockId"        => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "designBlockModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "imageDesignBlockId"        => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "imageDesignBlockModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "designTextId"        => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "designTextModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ]
        ];
    }

    /**
     * Sets Alignment value
     *
     * @param int $value
     *
     * @return int
     */
    protected function setAlignment($value)
    {
        if (!array_key_exists($value, $this->getAlignmentList())) {
            $value = self::ALIGNMENT_LEFT;
        }

        return $value;
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

    /**
     * Gets alignment list
     *
     * @return array
     */
    public function getAlignmentList()
    {
        return [
            self::ALIGNMENT_LEFT   => "",
            self::ALIGNMENT_CENTER  => "",
            self::ALIGNMENT_RIGHT => ""
        ];
    }
}