<?php

namespace testS\models;

use testS\components\Language;
use testS\components\ValueGenerator;
use testS\components\View;

/**
 * Model for working with table "designImageSimple"
 *
 * @package testS\models
 */
class DesignImageSimpleModel extends AbstractModel
{

    // Type
    const TYPE = "image-simple";

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
     * Gets labels
     *
     * @return array
     */
    public static function getLabels()
    {
        return [

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
            "alignment"          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::getAlignmentList(), self::ALIGNMENT_LEFT]
                ],
            ]
        ];
    }

    /**
     * Gets design
     *
     * @param string $selector
     * @param string $namespace
     *
     * @return array
     */
    public function getDesign($selector, $namespace = null)
    {
        if ($namespace === null) {
            $namespace = "designImageSimpleModel";
        }

        return [
            $this->get("containerDesignBlockModel")->getDesign(
                $selector,
                $namespace . ".containerDesignBlockModel",
                ["id"],
                Language::t("design", "imagesContainer")
            ),
            $this->get("imageDesignBlockModel")->getDesign(
                $selector . " .image-instance",
                $namespace . ".imageDesignBlockModel",
                ["id"],
                Language::t("design", "imageBlock")
            ),
            [
                "selector"  => $selector,
                "id"        => View::generateCssId($selector, self::TYPE),
                "type"      => self::TYPE,
                "title"     => Language::t("design", "image"),
                "namespace" => $namespace,
                "labels"    => self::getLabels(),
                "values"    => $this->get(null, ["id"]),
            ]
        ];
    }
}