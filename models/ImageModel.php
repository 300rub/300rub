<?php

namespace testS\models;

use testS\components\exceptions\ModelException;
use testS\components\Language;

/**
 * Model for working with table "images"
 *
 * @package testS\models
 *
 * @method ImageModel[] findAll
 * @method ImageModel   byId($id)
 * @method ImageModel   find
 * @method ImageModel   withAll
 */
class ImageModel extends AbstractModel
{

    /**
     * Crop types
     */
    const AUTO_CROP_TYPE_NONE = 0;
    const AUTO_CROP_TYPE_TOP_LEFT = 1;
    const AUTO_CROP_TYPE_TOP_CENTER = 2;
    const AUTO_CROP_TYPE_TOP_RIGHT = 3;
    const AUTO_CROP_TYPE_MIDDLE_LEFT = 4;
    const AUTO_CROP_TYPE_MIDDLE_CENTER = 5;
    const AUTO_CROP_TYPE_MIDDLE_RIGHT = 6;
    const AUTO_CROP_TYPE_BOTTOM_LEFT = 7;
    const AUTO_CROP_TYPE_BOTTOM_CENTER = 8;
    const AUTO_CROP_TYPE_BOTTOM_RIGHT = 9;

    /**
     * Types
     */
    const TYPE_ZOOM = 0;
    const TYPE_SLIDER = 1;
    const TYPE_SIMPLE = 2;

    /**
     * Gets model object
     *
     * @return ImageModel
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
        return "images";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    protected function getFieldsInfo()
    {
        return [
            "name"                => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => ["required", "max" => 255],
                self::FIELD_SET        => ["clearStripTags"],
            ],
            "language"            => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
                self::FIELD_SET  => ["setLanguage"],
            ],
            "designBlockId"       => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "designBlockModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "designImageSliderId" => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "designImageSliderModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "designImageZoomId"   => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "designImageZoomModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "designImageSimpleId" => [
                self::FIELD_RELATION => [
                    self::FIELD_RELATION_MODEL => "DesignBlockModel",
                    self::FIELD_RELATION_NAME  => "designImageSimpleModel",
                    self::FIELD_RELATION_TYPE  => self::FIELD_RELATION_TYPE_BELONGS_TO
                ]
            ],
            "type"                => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "autoCropType"        => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "cropWidth"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "cropHeight"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "cropX"               => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "cropY"               => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "thumbAutoCropType"   => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "thumbCropX"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "thumbCropY"          => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            "useAlbums"           => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
        ];
    }

    /**
     * Sets values
     */
    protected function setValues()
    {
        $this->language = intval($this->language);
        if ($this->language === 0
            || !array_key_exists($this->language, Language::$aliasList)
        ) {
            $this->language = Language::$activeId;
        }

        $this->designBlockId = intval($this->designBlockId);
        $this->designImageSliderId = intval($this->designImageSliderId);
        $this->designImageZoomId = intval($this->designImageZoomId);
        $this->designImageSimpleId = intval($this->designImageSimpleId);
        $this->type = intval($this->type);

        $this->autoCropType = intval($this->autoCropType);
        $this->cropWidth = intval($this->cropWidth);
        $this->cropHeight = intval($this->cropHeight);
        $this->cropX = intval($this->cropX);
        $this->cropY = intval($this->cropY);
        $this->thumbAutoCropType = intval($this->autoCropType);
        $this->thumbCropX = intval($this->cropX);
        $this->thumbCropY = intval($this->cropY);

        $this->useAlbums = boolval($this->useAlbums);
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

        $this->designImageSliderModel = $this->getRelationModel(
            $this->designImageSliderModel,
            $this->designImageSliderId,
            "DesignImageSliderModel"
        );

        $this->designImageZoomModel = $this->getRelationModel(
            $this->designImageZoomModel,
            $this->designImageZoomId,
            "DesignImageZoomModel"
        );

        $this->designImageSimpleModel = $this->getRelationModel(
            $this->designImageSimpleModel,
            $this->designImageSimpleId,
            "DesignBlockModel"
        );

        $typeList = self::getTypeList();
        if (!array_key_exists($this->type, $typeList)) {
            $this->type = self::TYPE_ZOOM;
        }

        $autoCropTypeList = $this->getAutoCropTypeList();

        if (!array_key_exists($this->autoCropType, $autoCropTypeList)) {
            $this->autoCropType = self::AUTO_CROP_TYPE_MIDDLE_CENTER;
        }
        $this->cropWidth = $this->getIntVal($this->cropWidth, ImageInstanceModel::MAX_SIZE);
        $this->cropHeight = $this->getIntVal($this->cropHeight, ImageInstanceModel::MAX_SIZE);
        $this->cropX = $this->getIntVal($this->cropX);
        $this->cropY = $this->getIntVal($this->cropY);

        if (!array_key_exists($this->thumbAutoCropType, $autoCropTypeList)) {
            $this->thumbAutoCropType = self::AUTO_CROP_TYPE_MIDDLE_CENTER;
        }
        $this->thumbCropX = $this->getIntVal($this->thumbCropX);
        $this->thumbCropY = $this->getIntVal($this->thumbCropY);

        $this->useAlbums = $this->getTinyIntVal($this->useAlbums);

        parent::beforeSave();
    }

    /**
     * Runs before validation
     *
     * @return void
     */
    protected function beforeValidate()
    {
        $this->name = trim(strip_tags($this->name));
    }

    /**
     * Duplicates image
     * If success returns ID of new image
     *
     * @return ImageModel
     *
     * @throws ModelException
     */
    public function duplicate()
    {
        $modelForCopy = $this->withAll()->byId($this->id)->find();

        $model = clone $this;
        $model->id = 0;
        $model->name = Language::t("common", "copy") . " {$this->name}";
        $model->designBlockModel = $modelForCopy->designBlockModel->duplicate();
        $model->designImageSimpleModel = $modelForCopy->designImageSimpleModel->duplicate();
        $model->designImageSliderModel = $modelForCopy->designImageSliderModel->duplicate();
        $model->designImageZoomModel = $modelForCopy->designImageZoomModel->duplicate();
        if (!$model->save()) {
            $fields = "";
            foreach ($model->getFieldNames() as $fieldName) {
                $fields .= " {$fieldName}: " . $model->$fieldName;
            }
            throw new ModelException(
                "Unable to duplicate ImageModel with fields: {fields}",
                [
                    "fields" => $fields
                ]
            );
        }

        return $model;
    }

    /**
     * Runs before delete
     *
     * @throws ModelException
     */
    protected function beforeDelete()
    {
        $imageAlbums = ImageAlbumModel::model()->byImageId($this->id)->findAll();
        foreach ($imageAlbums as $imageAlbum) {
            if (!$imageAlbum->delete()) {
                throw new ModelException(
                    "Unable to delete ImageAlbumModel model with ID = {id}",
                    [
                        "id" => $imageAlbum->id
                    ]
                );
            }
        }

        $this
            ->deleteRelation($this->designBlockModel, $this->designBlockId, "DesignBlockModel")
            ->deleteRelation($this->designImageZoomModel, $this->designImageZoomId, "DesignImageZoomModel")
            ->deleteRelation($this->designImageSliderModel, $this->designImageSliderId, "DesignImageSliderModel")
            ->deleteRelation($this->designImageSimpleModel, $this->designImageSimpleId, "DesignBlockModel");

        parent::beforeDelete();
    }

    /**
     * Gets crop type list
     *
     * @return array
     */
    public function getAutoCropTypeList()
    {
        return [
            self::AUTO_CROP_TYPE_NONE          => "",
            self::AUTO_CROP_TYPE_TOP_LEFT      => "",
            self::AUTO_CROP_TYPE_TOP_CENTER    => "",
            self::AUTO_CROP_TYPE_TOP_RIGHT     => "",
            self::AUTO_CROP_TYPE_MIDDLE_LEFT   => "",
            self::AUTO_CROP_TYPE_MIDDLE_CENTER => "",
            self::AUTO_CROP_TYPE_MIDDLE_RIGHT  => "",
            self::AUTO_CROP_TYPE_BOTTOM_LEFT   => "",
            self::AUTO_CROP_TYPE_BOTTOM_CENTER => "",
            self::AUTO_CROP_TYPE_BOTTOM_RIGHT  => ""
        ];
    }

    /**
     * Gets type list
     *
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_ZOOM   => "",
            self::TYPE_SLIDER => "",
            self::TYPE_SIMPLE => ""
        ];
    }
}