<?php

namespace testS\models;

/**
 * Model for working with table "designImageSliders"
 *
 * @package testS\models
 */
class DesignImageSliderModel extends AbstractDesignModel
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
     * Gets model object
     *
     * @return DesignImageSliderModel
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
        return "designImageSliders";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    protected function getFieldsInfo()
    {
        return [
            "designBlockId"            => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "designBlockModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "effect"                   => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setEffect"]
            ],
            "hasAutoPlay"              => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL,
            ],
            "playSpeed"                => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "navigationDesignBlockId"  => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "navigationDesignBlockModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "navigationAlignment"      => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setNavigationAlignment"]
            ],
            "descriptionDesignBlockId" => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "descriptionDesignBlockModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "descriptionAlignment"     => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setDescriptionAlignment"]
            ],
        ];
    }

    /**
     * Sets Effect
     *
     * @param int $value
     *
     * @return int
     */
    protected function setEffect($value)
    {
        if (!array_key_exists($value, $this->getEffectList())) {
            $value = self::EFFECT_NONE;
        }

        return $value;
    }

    /**
     * Sets Navigation Alignment value
     *
     * @param int $value
     *
     * @return int
     */
    protected function setNavigationAlignment($value)
    {
        if (!array_key_exists($value, $this->getNavigationAlignmentList())) {
            $value = self::NAVIGATION_ALIGNMENT_BOTTOM_CENTER;
        }

        return $value;
    }

    /**
     * Sets Description Alignment value
     *
     * @param int $value
     *
     * @return int
     */
    protected function setDescriptionAlignment($value)
    {
        if (!array_key_exists($value, $this->getDescriptionAlignmentList())) {
            $value = self::DESCRIPTION_ALIGNMENT_LEFT;
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
            ->setDesignValue("imageSlider", "effect", "effect", $name)
            ->setDesignValue("imageSlider", "isAutoPlay", "isAutoPlay", $name)
            ->setDesignValue("imageSlider", "playSpeed", "playSpeed", $name)
            ->setDesignValue("imageSlider", "navigationAlignment", "navigationAlignment", $name)
            ->setDesignValue("imageSlider", "descriptionAlignment", "descriptionAlignment", $name);

        return $this->designValues;
    }

    /**
     * Gets navigation alignment list
     *
     * @return array
     */
    public function getNavigationAlignmentList()
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
     * Gets description alignment list
     *
     * @return array
     */
    public function getDescriptionAlignmentList()
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
     * Gets a list of effects
     *
     * @return array
     */
    public function getEffectList()
    {
        return [];
    }
}