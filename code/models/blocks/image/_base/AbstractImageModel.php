<?php

namespace ss\models\blocks\image\_base;

use ss\application\App;
use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\blocks\_abstract\AbstractContentModel;

/**
 * Abstract model for working with table "images"
 */
abstract class AbstractImageModel extends AbstractContentModel
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
     * Gets crop type list
     *
     * @return array
     */
    public function getAutoCropTypeList()
    {
        return [
            self::AUTO_CROP_TYPE_NONE          => '',
            self::AUTO_CROP_TYPE_TOP_LEFT      => '',
            self::AUTO_CROP_TYPE_TOP_CENTER    => '',
            self::AUTO_CROP_TYPE_TOP_RIGHT     => '',
            self::AUTO_CROP_TYPE_MIDDLE_LEFT   => '',
            self::AUTO_CROP_TYPE_MIDDLE_CENTER => '',
            self::AUTO_CROP_TYPE_MIDDLE_RIGHT  => '',
            self::AUTO_CROP_TYPE_BOTTOM_LEFT   => '',
            self::AUTO_CROP_TYPE_BOTTOM_CENTER => '',
            self::AUTO_CROP_TYPE_BOTTOM_RIGHT  => ''
        ];
    }

    /**
     * Gets type list
     *
     * @return array
     */
    public function getTypeList()
    {
        $language = App::getInstance()->getLanguage();

        return [
            self::TYPE_ZOOM   => $language->getMessage('image', 'zoom'),
            self::TYPE_SLIDER => $language->getMessage('image', 'slider'),
            self::TYPE_SIMPLE => $language->getMessage('image', 'simple'),
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'images';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'designBlockId'       => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\block\\DesignBlockModel'
            ],
            'designImageAlbumId' => [
                self::FIELD_RELATION
                => '\\ss\\models\\blocks\\image\\DesignImageAlbumModel'
            ],
            'designImageSliderId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\image\\DesignImageSliderModel'
            ],
            'designImageZoomId'   => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\image\\DesignImageZoomModel'
            ],
            'designImageSimpleId' => [
                self::FIELD_RELATION
                    => '\\ss\\models\\blocks\\image\\DesignImageSimpleModel'
            ],
            'type'                => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        $this->getTypeList(),
                        self::TYPE_ZOOM]

                ],
            ],
            'viewAutoCropType'        => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        $this->getAutoCropTypeList(),
                        self::AUTO_CROP_TYPE_NONE
                    ]
                ],
            ],
            'viewCropX'               => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                ],
            ],
            'viewCropY'               => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                ],
            ],
            'thumbAutoCropType'   => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        $this->getAutoCropTypeList(),
                        self::AUTO_CROP_TYPE_NONE
                    ]
                ],
            ],
            'thumbCropX'          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                ],
            ],
            'thumbCropY'          => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::MIN => 0,
                ],
            ],
            'useAlbums'           => [
                self::FIELD_TYPE => self::FIELD_TYPE_BOOL
            ],
        ];
    }
}
