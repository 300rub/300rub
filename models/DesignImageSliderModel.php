<?php

namespace testS\models;

/**
 * Model for working with table "designImageSliders"
 *
 * @package testS\models
 */
class DesignImageSliderModel extends AbstractModel
{

    /**
     * Navigation alignments
     */
    const NAVIGATION_ALIGNMENT_NONE = 0;
    const NAVIGATION_ALIGNMENT_TOP_LEFT = 1;
    const NAVIGATION_ALIGNMENT_TOP_CENTER = 2;
    const NAVIGATION_ALIGNMENT_TOP_RIGHT = 3;
    const NAVIGATION_ALIGNMENT_MIDDLE_LEFT = 4;
    const NAVIGATION_ALIGNMENT_MIDDLE_CENTER = 5;
    const NAVIGATION_ALIGNMENT_MIDDLE_RIGHT = 6;
    const NAVIGATION_ALIGNMENT_BOTTOM_LEFT = 7;
    const NAVIGATION_ALIGNMENT_BOTTOM_CENTER = 8;
    const NAVIGATION_ALIGNMENT_BOTTOM_RIGHT = 9;

    /**
     * Description alignments
     */
    const DESCRIPTION_ALIGNMENT_NONE = 0;
    const DESCRIPTION_ALIGNMENT_TOP = 1;
    const DESCRIPTION_ALIGNMENT_LEFT = 2;
    const DESCRIPTION_ALIGNMENT_RIGHT = 3;
    const DESCRIPTION_ALIGNMENT_BOTTOM = 4;

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
            self::DESCRIPTION_ALIGNMENT_LEFT   => "",
            self::DESCRIPTION_ALIGNMENT_RIGHT  => "",
            self::DESCRIPTION_ALIGNMENT_BOTTOM => ""
        ];
    }

    /**
     * Gets navigation alignment list
     *
     * @return array
     */
    public static function getNavigationAlignmentList()
    {
        return [
            self::NAVIGATION_ALIGNMENT_NONE          => "",
            self::NAVIGATION_ALIGNMENT_TOP_LEFT      => "",
            self::NAVIGATION_ALIGNMENT_TOP_CENTER    => "",
            self::NAVIGATION_ALIGNMENT_TOP_RIGHT     => "",
            self::NAVIGATION_ALIGNMENT_MIDDLE_LEFT   => "",
            self::NAVIGATION_ALIGNMENT_MIDDLE_CENTER => "",
            self::NAVIGATION_ALIGNMENT_MIDDLE_RIGHT  => "",
            self::NAVIGATION_ALIGNMENT_BOTTOM_LEFT   => "",
            self::NAVIGATION_ALIGNMENT_BOTTOM_CENTER => "",
            self::NAVIGATION_ALIGNMENT_BOTTOM_RIGHT  => ""
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
        return "designImageSliders";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "designBlockId"            => [
                self::FIELD_RELATION => ["DesignBlockModel", "designBlockModel"]
            ],
            "navigationDesignBlockId"  => [
                self::FIELD_RELATION => ["DesignBlockModel", "navigationDesignBlockModel"]
            ],
            "descriptionDesignBlockId" => [
                self::FIELD_RELATION => ["DesignBlockModel", "descriptionDesignBlockModel"]
            ],
            "effect"                   => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "arrayKey" => [self::getEffectList(), self::EFFECT_NONE]
                ],
            ],
            "hasAutoPlay"              => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "playSpeed"                => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "min" => 0
                ],
            ],
            "navigationAlignment"      => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "arrayKey" => [self::getNavigationAlignmentList(), self::NAVIGATION_ALIGNMENT_BOTTOM_CENTER]
                ],
            ],
            "descriptionAlignment"     => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    "arrayKey" => [self::getDescriptionAlignmentList(), self::DESCRIPTION_ALIGNMENT_LEFT]
                ],
            ]
        ];
    }
}