<?php

namespace testS\models;

/**
 * Model for working with table "designImageZooms"
 *
 * @package testS\models
 */
class DesignImageZoomModel extends AbstractDesignModel
{

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
        return [];
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
    protected function getFieldsInfo()
    {
        return [
            "designBlockId"        => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "designBlockModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "hasScroll"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "thumbsAlignment"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => [
                    "arrayKey" => [self::getThumbsAlignmentList(), self::THUMBS_ALIGNMENT_NONE]
                ],
            ],
            "descriptionAlignment" => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => [
                    "arrayKey" => [self::getDescriptionAlignmentList(), self::DESCRIPTION_ALIGNMENT_NONE]
                ],
            ],
            "effect"               => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => [
                    "arrayKey" => [self::getEffectList(), self::EFFECT_NONE]
                ],
            ],
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
            ->setDesignValue("imageZoom", "isScroll", "isScroll", $name)
            ->setDesignValue("imageZoom", "thumbsAlignment", "thumbsAlignment", $name)
            ->setDesignValue("imageZoom", "descriptionAlignment", "descriptionAlignment", $name)
            ->setDesignValue("imageZoom", "effect", "effect", $name);

        return $this->designValues;
    }
}