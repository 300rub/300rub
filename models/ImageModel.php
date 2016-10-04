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
     * Crop type. None
     */
    const AUTO_CROP_TYPE_NONE = 0;

    /**
     * Crop type. Top Left
     */
    const AUTO_CROP_TYPE_TOP_LEFT = 1;

    /**
     * Crop type. Top Center
     */
    const AUTO_CROP_TYPE_TOP_CENTER = 2;

    /**
     * Crop type. Top Right
     */
    const AUTO_CROP_TYPE_TOP_RIGHT = 3;

    /**
     * Crop type. Middle Left
     */
    const AUTO_CROP_TYPE_MIDDLE_LEFT = 4;

    /**
     * Crop type. Middle Center
     */
    const AUTO_CROP_TYPE_MIDDLE_CENTER = 5;

    /**
     * Crop type. Middle Right
     */
    const AUTO_CROP_TYPE_MIDDLE_RIGHT = 6;

    /**
     * Crop type. Bottom Left
     */
    const AUTO_CROP_TYPE_BOTTOM_LEFT = 7;

    /**
     * Crop type. Bottom Center
     */
    const AUTO_CROP_TYPE_BOTTOM_CENTER = 8;

    /**
     * Crop type. Bottom Right
     */
    const AUTO_CROP_TYPE_BOTTOM_RIGHT = 9;

    /**
     * Default crop type
     */
    const DEFAULT_AUTO_CROP_TYPE = self::AUTO_CROP_TYPE_MIDDLE_CENTER;

    /**
     * Type. Zoom
     */
    const TYPE_ZOOM = 0;

    /**
     * Type. Slider
     */
    const TYPE_SLIDER = 1;

    /**
     * Type. Simple
     */
    const TYPE_SIMPLE = 2;

    /**
     * Default type
     */
    const DEFAULT_TYPE = self::TYPE_ZOOM;

    /**
     * Block's name
     *
     * @var string
     */
    public $name;

    /**
     * Language ID
     *
     * @var integer
     */
    public $language;

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
     * ID of design image slider
     *
     * @var integer
     */
    public $designImageSliderId;

    /**
     * Design image slider model
     *
     * @var DesignImageSliderModel
     */
    public $designImageSliderModel;

    /**
     * ID of design image slider
     *
     * @var integer
     */
    public $designImageZoomId;

    /**
     * Design image zoom model
     *
     * @var DesignImageZoomModel
     */
    public $designImageZoomModel;

    /**
     * ID of design image simple
     *
     * @var integer
     */
    public $designImageSimpleId;

    /**
     * Design image simple model
     *
     * @var DesignBlockModel
     */
    public $designImageSimpleModel;

    /**
     * Type
     *
     * @var int
     */
    public $type;

    /**
     * Crop type
     *
     * @var integer
     */
    public $autoCropType;

    /**
     * Crop width
     *
     * @var integer
     */
    public $cropWidth;

    /**
     * Crop height
     *
     * @var integer
     */
    public $cropHeight;

    /**
     * Crop crop x proportion
     *
     * @var integer
     */
    public $cropX;

    /**
     * Crop crop y proportion
     *
     * @var integer
     */
    public $cropY;

    /**
     * Crop type for thumbs
     *
     * @var integer
     */
    public $thumbAutoCropType;

    /**
     * Crop crop x proportion for thumbs
     *
     * @var integer
     */
    public $thumbCropX;

    /**
     * Crop crop y proportion for thumbs
     *
     * @var integer
     */
    public $thumbCropY;

    /**
     * Is use albums
     *
     * @var boolean
     */
    public $useAlbums;

    /**
     * Form types
     *
     * @var array
     */
    protected $formTypes = [
        "name" => self::FORM_TYPE_FIELD,
    ];

    /**
     * Relations
     *
     * @var array
     */
    protected $relations = [
        "designBlockModel"       => ['testS\models\DesignBlockModel', "designBlockId"],
        "designImageSliderModel" => ['testS\models\DesignImageSliderModel', "designImageSliderId"],
        "designImageZoomModel"   => ['testS\models\DesignImageZoomModel', "designImageZoomId"],
        "designImageSimpleModel" => ['testS\models\DesignBlockModel', "designImageSliderId"]
    ];

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
     * Validation rules
     *
     * @return array
     */
    public function getRules()
    {
        return [
            "name"                   => ["required", "max" => 255],
            "language"               => [],
            "designBlockId"        => [],
            "designImageSliderId" => [],
            "designImageZoomId"   => [],
            "designImageSimpleId" => [],
            "type"                   => [],
            "autoCropType"         => [],
            "cropWidth"             => [],
            "cropHeight"            => [],
            "cropX"                 => [],
            "cropY"                 => [],
            "thumbAutoCropType"   => [],
            "thumbCropX"           => [],
            "thumbCropY"           => [],
            "useAlbums"             => [],
        ];
    }

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
            $this->type = self::DEFAULT_TYPE;
        }

        $autoCropTypeList = $this->getAutoCropTypeList();

        if (!array_key_exists($this->autoCropType, $autoCropTypeList)) {
            $this->autoCropType = self::DEFAULT_AUTO_CROP_TYPE;
        }
        $this->cropWidth = $this->getIntVal($this->cropWidth, ImageInstanceModel::MAX_SIZE);
        $this->cropHeight = $this->getIntVal($this->cropHeight, ImageInstanceModel::MAX_SIZE);
        $this->cropX = $this->getIntVal($this->cropX);
        $this->cropY = $this->getIntVal($this->cropY);

        if (!array_key_exists($this->thumbAutoCropType, $autoCropTypeList)) {
            $this->thumbAutoCropType = self::DEFAULT_AUTO_CROP_TYPE;
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