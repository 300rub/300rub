<?php

namespace models;

use components\exceptions\ModelException;

/**
 * Model for working with table "design_image_sliders"
 *
 * @package models
 */
class DesignImageSliderModel extends AbstractModel
{

    /**
     * Navigation alignment. Top Left
     */
    const NAVIGATION_ALIGNMENT_TOP_LEFT = 1;

    /**
     * Navigation alignment. Top Center
     */
    const NAVIGATION_ALIGNMENT_TOP_CENTER = 2;

    /**
     * Navigation alignment. Top Right
     */
    const NAVIGATION_ALIGNMENT_TOP_RIGHT = 3;

    /**
     * Navigation alignment. Middle Left
     */
    const NAVIGATION_ALIGNMENT_MIDDLE_LEFT = 4;

    /**
     * Navigation alignment. Middle Center
     */
    const NAVIGATION_ALIGNMENT_MIDDLE_CENTER = 5;

    /**
     * Navigation alignment. Middle Right
     */
    const NAVIGATION_ALIGNMENT_MIDDLE_RIGHT = 6;

    /**
     * Navigation alignment. Bottom Left
     */
    const NAVIGATION_ALIGNMENT_BOTTOM_LEFT = 7;

    /**
     * Navigation alignment. Bottom Center
     */
    const NAVIGATION_ALIGNMENT_BOTTOM_CENTER = 8;

    /**
     * Navigation alignment. Bottom Right
     */
    const NAVIGATION_ALIGNMENT_BOTTOM_RIGHT = 9;

    /**
     * Default Navigation alignment
     */
    const DEFAULT_NAVIGATION_ALIGNMENT = self::NAVIGATION_ALIGNMENT_BOTTOM_CENTER;

    /**
     * Description alignment. Top
     */
    const DESCRIPTION_ALIGNMENT_TOP = 1;

    /**
     * Description alignment. Left
     */
    const DESCRIPTION_ALIGNMENT_LEFT = 2;

    /**
     * Description alignment. Right
     */
    const DESCRIPTION_ALIGNMENT_RIGHT = 3;

    /**
     * Description alignment. Bottom
     */
    const DESCRIPTION_ALIGNMENT_BOTTOM = 4;

    /**
     * Default Description alignment
     */
    const DEFAULT_DESCRIPTION_ALIGNMENT = self::DESCRIPTION_ALIGNMENT_LEFT;

    /**
     * Default effect
     */
    const DEFAULT_EFFECT = 1;

    /**
     * ID of design block
     *
     * @var integer
     */
    public $design_block_id;

    /**
     * Design block model
     *
     * @var DesignBlockModel
     */
    public $designBlockModel;

    /**
     * Effect
     *
     * @var int
     */
    public $effect;

    /**
     * Flag of auto playing
     *
     * @var bool
     */
    public $is_auto_play;

    /**
     * Play speed in seconds
     *
     * @var int
     */
    public $play_speed;

    /**
     * ID of navigation design block
     *
     * @var int
     */
    public $navigation_design_block_id;

    /**
     * Navigation design block model
     *
     * @var DesignBlockModel
     */
    public $navigationDesignBlockModel;

    /**
     * Navigation alignment
     *
     * @var int
     */
    public $navigation_alignment;

    /**
     * ID of description design block
     *
     * @var int
     */
    public $description_design_block_id;

    /**
     * Description design block model
     *
     * @var DesignBlockModel
     */
    public $descriptionDesignBlockModel;

    /**
     * Description alignment
     *
     * @var int
     */
    public $description_alignment;

    /**
     * Relations
     *
     * @var array
     */
    protected $relations = [
        "designBlockModel"            => ['models\DesignBlockModel', "design_block_id"],
        "navigationDesignBlockModel"  => ['models\DesignBlockModel', "navigation_design_block_id"],
        "descriptionDesignBlockModel" => ['models\DesignBlockModel', "description_design_block_id"],
    ];

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "design_image_sliders";
    }

    /**
     * Validation rules
     *
     * @return array
     */
    public function getRules()
    {
        return [
            "design_block_id"             => [],
            "effect"                      => [],
            "is_auto_play"                => [],
            "play_speed"                  => [],
            "navigation_design_block_id"  => [],
            "navigation_alignment"        => [],
            "description_design_block_id" => [],
            "description_alignment"       => [],
        ];
    }

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
     * Sets values
     */
    protected function setValues()
    {
        $this->design_block_id = intval($this->design_block_id);
        $this->effect = intval($this->effect);
        $this->is_auto_play = boolval($this->is_auto_play);
        $this->play_speed = intval($this->play_speed);
        $this->navigation_design_block_id = intval($this->navigation_design_block_id);
        $this->navigation_alignment = intval($this->navigation_alignment);
        $this->description_design_block_id = intval($this->description_design_block_id);
        $this->description_alignment = intval($this->description_alignment);
    }

    /**
     * Runs before save
     */
    protected function beforeSave()
    {
        $this->designBlockModel = $this->getRelationModel(
            $this->designBlockModel,
            $this->design_block_id,
            "DesignBlockModel"
        );

        $this->navigationDesignBlockModel = $this->getRelationModel(
            $this->navigationDesignBlockModel,
            $this->navigation_design_block_id,
            "DesignBlockModel"
        );

        $this->descriptionDesignBlockModel = $this->getRelationModel(
            $this->descriptionDesignBlockModel,
            $this->description_design_block_id,
            "DesignBlockModel"
        );

        $effectList = $this->getEffectList();
        if (!array_key_exists($this->effect, $effectList)) {
            $this->effect = self::DEFAULT_EFFECT;
        }

        $this->is_auto_play = $this->getTinyIntVal($this->is_auto_play);

        $navigationAlignmentList = $this->getNavigationAlignmentList();
        if (!array_key_exists($this->navigation_alignment, $navigationAlignmentList)) {
            $this->navigation_alignment = self::DEFAULT_NAVIGATION_ALIGNMENT;
        }

        $getDescriptionAlignmentList = $this->getDescriptionAlignmentList();
        if (!array_key_exists($this->description_alignment, $getDescriptionAlignmentList)) {
            $this->description_alignment = self::DEFAULT_DESCRIPTION_ALIGNMENT;
        }

        parent::beforeSave();
    }

    /**
     * Gets values for object
     *
     * @param string $name Name of object
     *
     * @return array
     */
    public function getValues($name)
    {
        return [
            "imageSlider" => [
                "effect"                => [
                    "name"  => sprintf($name, "effect"),
                    "value" => $this->effect,
                ],
                "isAutoPlay"            => [
                    "name"  => sprintf($name, "is_auto_play"),
                    "value" => $this->is_auto_play,
                ],
                "playSpeed"             => [
                    "name"  => sprintf($name, "play_speed"),
                    "value" => $this->play_speed,
                ],
                "navigationAlignment"   => [
                    "name"  => sprintf($name, "navigation_alignment"),
                    "value" => $this->navigation_alignment,
                ],
                "description_alignment" => [
                    "name"  => sprintf($name, "description_alignment"),
                    "value" => $this->description_alignment,
                ]
            ]
        ];
    }

    /**
     * Runs before delete
     */
    protected function beforeDelete()
    {
        $this
            ->deleteRelation($this->designBlockModel, $this->design_block_id, "DesignBlockModel")
            ->deleteRelation($this->navigationDesignBlockModel, $this->navigation_design_block_id, "DesignBlockModel")
            ->deleteRelation(
                $this->descriptionDesignBlockModel,
                $this->description_design_block_id,
                "DesignBlockModel"
            );

        parent::beforeDelete();
    }

    /**
     * Duplicates model
     *
     * @return DesignImageSliderModel
     *
     * @throws ModelException
     */
    public function duplicate()
    {
        $model = clone $this;
        $model->id = 0;
        $model->designBlockModel = $this->designBlockModel->duplicate();
        $model->navigationDesignBlockModel = $this->navigationDesignBlockModel->duplicate();
        $model->descriptionDesignBlockModel = $this->descriptionDesignBlockModel->duplicate();

        if (!$model->save()) {
            $fields = "";
            foreach ($model->getFieldNames() as $fieldName) {
                $fields .= " {$fieldName}: " . $model->$fieldName;
            }
            throw new ModelException(
                "Unable to duplicate DesignImageSliderModel with fields: {fields}",
                [
                    "fields" => $fields
                ]
            );
        }

        return $model;
    }

    /**
     * Gets navigation alignment list
     *
     * @return array
     */
    public function getNavigationAlignmentList()
    {
        return [
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