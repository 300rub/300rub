<?php

namespace models;

use components\exceptions\ModelException;

/**
 * Model for working with table "design_image_zooms"
 *
 * @package models
 */
class DesignImageZoomModel extends AbstractModel
{

    /**
     * Description alignment. None
     */
    const DESCRIPTION_ALIGNMENT_NONE = 0;

    /**
     * Description alignment. Top
     */
    const DESCRIPTION_ALIGNMENT_TOP = 1;

    /**
     * Description alignment. Bottom
     */
    const DESCRIPTION_ALIGNMENT_BOTTOM = 2;

    /**
     * Default Description alignment
     */
    const DEFAULT_DESCRIPTION_ALIGNMENT = self::DESCRIPTION_ALIGNMENT_NONE;

    /**
     * Thumbs alignment. None
     */
    const THUMBS_ALIGNMENT_NONE = 0;

    /**
     * Thumbs alignment. Top
     */
    const THUMBS_ALIGNMENT_TOP = 1;

    /**
     * Thumbs alignment. Left
     */
    const THUMBS_ALIGNMENT_LEFT = 2;

    /**
     * Thumbs alignment. Right
     */
    const THUMBS_ALIGNMENT_RIGHT = 3;

    /**
     * Thumbs alignment. Bottom
     */
    const THUMBS_ALIGNMENT_BOTTOM = 4;

    /**
     * Default Description alignment
     */
    const DEFAULT_THUMBS_ALIGNMENT = self::THUMBS_ALIGNMENT_NONE;

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
     * Flag of mouse scrolling
     *
     * @var bool
     */
    public $is_scroll;

    /**
     * Thumbs alignment
     *
     * @var int
     */
    public $thumbs_alignment;

    /**
     * Description alignment
     *
     * @var int
     */
    public $description_alignment;

    /**
     * Effect
     *
     * @var int
     */
    public $effect;

    /**
     * Relations
     *
     * @var array
     */
    protected $relations = [
        "designBlockModel" => ['models\DesignBlockModel', "designBlockId"],
    ];

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "design_image_zooms";
    }

    /**
     * Validation rules
     *
     * @return array
     */
    public function getRules()
    {
        return [
            "designBlockId"       => [],
            "is_scroll"             => [],
            "thumbs_alignment"      => [],
            "description_alignment" => [],
            "effect"                => [],
        ];
    }

    /**
     * Gets model object
     *
     * @return DesignImageZoomModel
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
        $this->is_scroll = boolval($this->is_scroll);
        $this->thumbs_alignment = intval($this->thumbs_alignment);
        $this->description_alignment = intval($this->description_alignment);
        $this->effect = intval($this->effect);
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

        $this->is_scroll = $this->getTinyIntVal($this->is_scroll);

        $getDescriptionAlignmentList = $this->getDescriptionAlignmentList();
        if (!array_key_exists($this->description_alignment, $getDescriptionAlignmentList)) {
            $this->description_alignment = self::DEFAULT_DESCRIPTION_ALIGNMENT;
        }

        $thumbsAlignmentList = $this->getThumbsAlignmentList();
        if (!array_key_exists($this->thumbs_alignment, $thumbsAlignmentList)) {
            $this->thumbs_alignment = self::DEFAULT_THUMBS_ALIGNMENT;
        }

        $effectList = $this->getEffectList();
        if (!array_key_exists($this->effect, $effectList)) {
            $this->effect = self::DEFAULT_EFFECT;
        }

        parent::beforeSave();
    }

    /**
     * Runs before delete
     */
    protected function beforeDelete()
    {
        $this->deleteRelation($this->designBlockModel, $this->designBlockId, "DesignBlockModel");

        parent::beforeDelete();
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
            "imageZoom" => [
                "isScroll"             => [
                    "name"  => sprintf($name, "is_scroll"),
                    "value" => $this->is_scroll,
                ],
                "thumbsAlignment"      => [
                    "name"  => sprintf($name, "thumbs_alignment"),
                    "value" => $this->thumbs_alignment,
                ],
                "descriptionAlignment" => [
                    "name"  => sprintf($name, "description_alignment"),
                    "value" => $this->description_alignment,
                ],
                "effect"               => [
                    "name"  => sprintf($name, "effect"),
                    "value" => $this->effect,
                ]
            ]
        ];
    }

    /**
     * Duplicates model
     *
     * @return DesignImageZoomModel
     *
     * @throws ModelException
     */
    public function duplicate()
    {
        $model = clone $this;
        $model->id = 0;
        $model->designBlockModel = $this->designBlockModel->duplicate();

        if (!$model->save()) {
            $fields = "";
            foreach ($model->getFieldNames() as $fieldName) {
                $fields .= " {$fieldName}: " . $model->$fieldName;
            }
            throw new ModelException(
                "Unable to duplicate DesignImageZoomModel with fields: {fields}",
                [
                    "fields" => $fields
                ]
            );
        }

        return $model;
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
            self::DESCRIPTION_ALIGNMENT_BOTTOM => ""
        ];
    }

    /**
     * Gets thumbs alignment list
     *
     * @return array
     */
    public function getThumbsAlignmentList()
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
    public function getEffectList()
    {
        return [];
    }
}