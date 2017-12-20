<?php

namespace testS\models;

use testS\components\Language;
use testS\components\ValueGenerator;
use testS\components\View;

/**
 * Model for working with table "designImageZooms"
 *
 * @package testS\models
 */
class DesignImageZoomModel extends AbstractModel
{

    // Type
    const TYPE = "image-zoom";

    /**
     * Description alignments
     */
    const DESCRIPTION_ALIGNMENT_NONE = 0;
    const DESCRIPTION_ALIGNMENT_TOP = 1;
    const DESCRIPTION_ALIGNMENT_BOTTOM = 2;

    /**
     * Thumbs alignments
     */
    const THUMBS_ALIGNMENT_NONE = 0;
    const THUMBS_ALIGNMENT_TOP = 1;
    const THUMBS_ALIGNMENT_LEFT = 2;
    const THUMBS_ALIGNMENT_RIGHT = 3;
    const THUMBS_ALIGNMENT_BOTTOM = 4;

    /**
     * Effects
     */
    const EFFECT_NONE = 0;

    /**
     * Gets description alignment list
     *
     * @return array
     */
    public static function getDescriptionAlignmentList()
    {
        return [
            self::DESCRIPTION_ALIGNMENT_NONE   => "",
            self::DESCRIPTION_ALIGNMENT_TOP    => "",
            self::DESCRIPTION_ALIGNMENT_BOTTOM => ""
        ];
    }

    /**
     * Gets thumbs alignment list
     *
     * @return array
     */
    public static function getThumbsAlignmentList()
    {
        return [
            self::THUMBS_ALIGNMENT_NONE   => "",
            self::THUMBS_ALIGNMENT_TOP    => "",
            self::THUMBS_ALIGNMENT_LEFT   => "",
            self::THUMBS_ALIGNMENT_RIGHT  => "",
            self::THUMBS_ALIGNMENT_BOTTOM => ""
        ];
    }

    /**
     * Gets a list of effects
     *
     * @return array
     */
    public static function getEffectList()
    {
        return [
            self::EFFECT_NONE => ""
        ];
    }

    /** Gets labels
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
        return "designImageZooms";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "designBlockId"        => [
                self::FIELD_RELATION => "DesignBlockModel"
            ],
            "hasScroll"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "thumbsAlignment"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getThumbsAlignmentList(),
                        self::THUMBS_ALIGNMENT_NONE
                    ]
                ],
            ],
            "descriptionAlignment" => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getDescriptionAlignmentList(),
                        self::DESCRIPTION_ALIGNMENT_NONE
                    ]
                ],
            ],
            "effect"               => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::getEffectList(), self::EFFECT_NONE]
                ],
            ],
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
            $namespace = "designImageZoomModel";
        }

        return [
            $this->get("designBlockModel")->getDesign(
                $selector,
                $namespace . ".designBlockModel",
                ["id"],
                Language::t("design", "imagesContainer")
            ),
            [
                "selector"  => $selector,
                "id"        => View::generateCssId($selector, self::TYPE),
                "type"      => self::TYPE,
                "title"     => Language::t("design", "image"),
                "namespace" => $namespace,
                "labels"    => self::getLabels(),
                "values" => $this->get(null, ["id", "designBlockId", "designBlockModel"])
            ]
        ];
    }
}