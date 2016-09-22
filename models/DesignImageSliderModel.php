<?php

namespace models;

use components\exceptions\ModelException;

/**
 * Model for working with table "designImageSliders"
 *
 * @package models
 */
class DesignImageSliderModel extends AbstractModel
{

    /**
     * Navigation alignment. None
     */
    const NAVIGATION_ALIGNMENT_NONE = 0;

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
     * Description alignment. None
     */
    const DESCRIPTION_ALIGNMENT_NONE = 0;

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
    public $designBlockId;

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
    public $isAutoPlay;

    /**
     * Play speed in seconds
     *
     * @var int
     */
    public $playSpeed;

    /**
     * ID of navigation design block
     *
     * @var int
     */
    public $navigationDesignBlockId;

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
    public $navigationAlignment;

    /**
     * ID of description design block
     *
     * @var int
     */
    public $descriptionDesignBlockId;

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
    public $descriptionAlignment;

    /**
     * Relations
     *
     * @var array
     */
    protected $relations = [
        "designBlockModel"            => ['models\DesignBlockModel', "designBlockId"],
        "navigationDesignBlockModel"  => ['models\DesignBlockModel', "navigationDesignBlockId"],
        "descriptionDesignBlockModel" => ['models\DesignBlockModel', "descriptionDesignBlockId"],
    ];

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
     * Validation rules
     *
     * @return array
     */
    public function getRules()
    {
        return [
            "designBlockId"             => [],
            "effect"                      => [],
            "isAutoPlay"                => [],
            "playSpeed"                  => [],
            "navigationDesignBlockId"  => [],
            "navigationAlignment"        => [],
            "descriptionDesignBlockId" => [],
            "descriptionAlignment"       => [],
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
        $this->designBlockId = intval($this->designBlockId);
        $this->effect = intval($this->effect);
        $this->isAutoPlay = boolval($this->isAutoPlay);
        $this->playSpeed = intval($this->playSpeed);
        $this->navigationDesignBlockId = intval($this->navigationDesignBlockId);
        $this->navigationAlignment = intval($this->navigationAlignment);
        $this->descriptionDesignBlockId = intval($this->descriptionDesignBlockId);
        $this->descriptionAlignment = intval($this->descriptionAlignment);
    }

    /**
     * Runs before save
     */
    protected function beforeSave()
    {
        $this->designBlockModel = $this->getRelationModel(
            $this->designBlockModel,
            $this->designBlockId,
            "DesignBlockModel"
        );

        $this->navigationDesignBlockModel = $this->getRelationModel(
            $this->navigationDesignBlockModel,
            $this->navigationDesignBlockId,
            "DesignBlockModel"
        );

        $this->descriptionDesignBlockModel = $this->getRelationModel(
            $this->descriptionDesignBlockModel,
            $this->descriptionDesignBlockId,
            "DesignBlockModel"
        );

        $effectList = $this->getEffectList();
        if (!array_key_exists($this->effect, $effectList)) {
            $this->effect = self::DEFAULT_EFFECT;
        }

        $this->isAutoPlay = $this->getTinyIntVal($this->isAutoPlay);

        $navigationAlignmentList = $this->getNavigationAlignmentList();
        if (!array_key_exists($this->navigationAlignment, $navigationAlignmentList)) {
            $this->navigationAlignment = self::DEFAULT_NAVIGATION_ALIGNMENT;
        }

        $getDescriptionAlignmentList = $this->getDescriptionAlignmentList();
        if (!array_key_exists($this->descriptionAlignment, $getDescriptionAlignmentList)) {
            $this->descriptionAlignment = self::DEFAULT_DESCRIPTION_ALIGNMENT;
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
                    "name"  => sprintf($name, "isAutoPlay"),
                    "value" => $this->isAutoPlay,
                ],
                "playSpeed"             => [
                    "name"  => sprintf($name, "playSpeed"),
                    "value" => $this->playSpeed,
                ],
                "navigationAlignment"   => [
                    "name"  => sprintf($name, "navigationAlignment"),
                    "value" => $this->navigationAlignment,
                ],
                "descriptionAlignment" => [
                    "name"  => sprintf($name, "descriptionAlignment"),
                    "value" => $this->descriptionAlignment,
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
            ->deleteRelation($this->designBlockModel, $this->designBlockId, "DesignBlockModel")
            ->deleteRelation($this->navigationDesignBlockModel, $this->navigationDesignBlockId, "DesignBlockModel")
            ->deleteRelation(
                $this->descriptionDesignBlockModel,
                $this->descriptionDesignBlockId,
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