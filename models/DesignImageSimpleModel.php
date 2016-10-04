<?php

namespace testS\models;

use testS\components\exceptions\ModelException;

/**
 * Model for working with table "designImageSimples"
 *
 * @package models
 */
class DesignImageSimpleModel extends AbstractModel
{

    /**
     * Alignment. Left
     */
    const ALIGNMENT_LEFT = 0;

    /**
     * Alignment. Center
     */
    const ALIGNMENT_CENTER = 1;

    /**
     * Alignment. Right
     */
    const ALIGNMENT_RIGHT = 2;

    /**
     * Default alignment
     */
    const DEFAULT_ALIGNMENT = self::ALIGNMENT_LEFT;

    /**
     * Alignment
     *
     * @var integer
     */
    public $alignment;

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
     * ID of image design block
     *
     * @var integer
     */
    public $imageDesignBlockId;

    /**
     * Design image block model
     *
     * @var DesignBlockModel
     */
    public $imageDesignBlockModel;

    /**
     * ID of design text
     *
     * @var integer
     */
    public $designTextId;

    /**
     * Design text model
     *
     * @var DesignTextModel
     */
    public $designTextModel;

    /**
     * Relations
     *
     * @var array
     */
    protected $relations = [
        "designBlockModel"      => ['models\DesignBlockModel', "designBlockId"],
        "imageDesignBlockModel" => ['models\DesignBlockModel', "imageDesignBlockId"],
        "designTextModel"       => ['models\DesignBlockModel', "designTextId"],
    ];

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
     * Validation rules
     *
     * @return array
     */
    public function getRules()
    {
        return [
            "alignment"             => [],
            "designBlockId"       => [],
            "imageDesignBlockId" => [],
            "designTextId"        => [],
        ];
    }

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
     * Sets values
     */
    protected function setValues()
    {
        $this->alignment = intval($this->alignment);
        $this->designBlockId = intval($this->designBlockId);
        $this->imageDesignBlockId = intval($this->imageDesignBlockId);
        $this->designTextId = intval($this->designTextId);
    }

    /**
     * Runs before save
     */
    protected function beforeSave()
    {
        $this->alignment = $this->getIntVal($this->alignment);

        $this->designBlockModel = $this->getRelationModel(
            $this->designBlockModel,
            $this->designBlockId,
            "DesignBlockModel"
        );

        $this->imageDesignBlockModel = $this->getRelationModel(
            $this->imageDesignBlockModel,
            $this->imageDesignBlockId,
            "DesignBlockModel"
        );

        $this->designTextModel = $this->getRelationModel(
            $this->designTextModel,
            $this->designTextId,
            "DesignTextModel"
        );

        $alignmentList = $this->getAlignmentList();
        if (!array_key_exists($this->alignment, $alignmentList)) {
            $this->alignment = self::DEFAULT_ALIGNMENT;
        }

        parent::beforeSave();
    }

    /**
     * Runs before delete
     */
    protected function beforeDelete()
    {
        $this->deleteRelation($this->designBlockModel, $this->designBlockId, "DesignBlockModel");
        $this->deleteRelation($this->imageDesignBlockModel, $this->imageDesignBlockId, "DesignBlockModel");
        $this->deleteRelation($this->designTextModel, $this->designTextId, "DesignTextModel");

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
            "imageSimple" => [
                "alignment"             => [
                    "name"  => sprintf($name, "alignment"),
                    "value" => $this->alignment,
                ]
            ]
        ];
    }

    /**
     * Duplicates model
     *
     * @return DesignImageSimpleModel
     *
     * @throws ModelException
     */
    public function duplicate()
    {
        $model = clone $this;
        $model->id = 0;
        $model->designBlockModel = $this->designBlockModel->duplicate();
        $model->imageDesignBlockModel = $this->imageDesignBlockModel->duplicate();
        $model->designTextModel = $this->designTextModel->duplicate();

        if (!$model->save()) {
            $fields = "";
            foreach ($model->getFieldNames() as $fieldName) {
                $fields .= " {$fieldName}: " . $model->$fieldName;
            }
            throw new ModelException(
                "Unable to duplicate DesignImageSimpleModel with fields: {fields}",
                [
                    "fields" => $fields
                ]
            );
        }

        return $model;
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