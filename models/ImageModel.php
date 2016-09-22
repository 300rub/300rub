<?php

namespace models;

use components\exceptions\ModelException;
use components\Language;

/**
 * Model for working with table "images"
 *
 * @package models
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
     * Flag of using cropping
     *
     * @var bool
     */
    public $useCrop;

    /**
     * Crop type
     *
     * @var integer
     */
    public $auto_crop_type;

    /**
     * Crop width
     *
     * @var integer
     */
    public $crop_width;

    /**
     * Crop height
     *
     * @var integer
     */
    public $crop_height;

    /**
     * Crop crop x proportion
     *
     * @var integer
     */
    public $crop_x;

    /**
     * Crop crop y proportion
     *
     * @var integer
     */
    public $crop_y;

    /**
     * Crop type for thumbs
     *
     * @var integer
     */
    public $thumb_auto_crop_type;

    /**
     * Crop crop x proportion for thumbs
     *
     * @var integer
     */
    public $thumb_crop_x;

    /**
     * Crop crop y proportion for thumbs
     *
     * @var integer
     */
    public $thumb_crop_y;

    /**
     * Is use albums
     *
     * @var boolean
     */
    public $use_albums;

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
        "designBlockModel"       => ['models\DesignBlockModel', "designBlockId"],
        "designImageSliderModel" => ['models\DesignImageSliderModel', "designImageSliderId"],
        "designImageZoomModel"   => ['models\DesignImageZoomModel', "designImageZoomId"],
        "designImageSimpleModel" => ['models\DesignBlockModel', "designImageSliderId"]
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
            "useCrop"               => [],
            "auto_crop_type"         => [],
            "crop_width"             => [],
            "crop_height"            => [],
            "crop_x"                 => [],
            "crop_y"                 => [],
            "thumb_auto_crop_type"   => [],
            "thumb_crop_x"           => [],
            "thumb_crop_y"           => [],
            "use_albums"             => [],
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

        $this->useCrop = boolval($this->useCrop);
        $this->auto_crop_type = intval($this->auto_crop_type);
        $this->crop_width = intval($this->crop_width);
        $this->crop_height = intval($this->crop_height);
        $this->crop_x = intval($this->crop_x);
        $this->crop_y = intval($this->crop_y);
        $this->thumb_auto_crop_type = intval($this->auto_crop_type);
        $this->thumb_crop_x = intval($this->crop_x);
        $this->thumb_crop_y = intval($this->crop_y);

        $this->use_albums = boolval($this->use_albums);
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

        $this->useCrop = $this->getTinyIntVal($this->useCrop);

        if ($this->useCrop === 1) {
            $autoCropTypeList = $this->getAutoCropTypeList();

            if (!array_key_exists($this->auto_crop_type, $autoCropTypeList)) {
                $this->auto_crop_type = self::DEFAULT_AUTO_CROP_TYPE;
            }
            $this->crop_width = $this->getIntVal($this->crop_width, ImageInstanceModel::MAX_SIZE);
            $this->crop_height = $this->getIntVal($this->crop_height, ImageInstanceModel::MAX_SIZE);
            $this->crop_x = $this->getIntVal($this->crop_x);
            $this->crop_y = $this->getIntVal($this->crop_y);

            if (!array_key_exists($this->thumb_auto_crop_type, $autoCropTypeList)) {
                $this->thumb_auto_crop_type = self::DEFAULT_AUTO_CROP_TYPE;
            }
            $this->thumb_crop_x = $this->getIntVal($this->thumb_crop_x);
            $this->thumb_crop_y = $this->getIntVal($this->thumb_crop_y);
        }

        $this->use_albums = $this->getTinyIntVal($this->use_albums);

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