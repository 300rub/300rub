<?php

namespace testS\models\blocks\image\_abstract;

use testS\application\App;
use testS\application\components\ValueGenerator;
use testS\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "imageInstances"
 */
abstract class AbstractImageInstanceModel extends AbstractModel
{

    /**
     * Flips
     */
    const FLIP_NONE = 0;
    const FLIP_HORIZONTAL = 1;
    const FLIP_VERTICAL = 2;
    const FLIP_BOTH = 3;

    /**
     * Gets type list
     *
     * @return array
     */
    public static function getFlipList()
    {
        $language = App::getInstance()->getLanguage();

        return [
            self::FLIP_NONE
                => $language->getMessage('image', 'flipNone'),
            self::FLIP_HORIZONTAL
                => $language->getMessage('image', 'flipHorizontal'),
            self::FLIP_VERTICAL
                => $language->getMessage('image', 'flipVertical'),
            self::FLIP_BOTH
                => $language->getMessage('image', 'flipBoth'),
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'imageInstances';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return array_merge(
            $this->_getFieldsInfoRelations(),
            $this->_getFieldsInfoCoordinates(),
            $this->_getFieldsInfoCommon()
        );
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    private function _getFieldsInfoRelations()
    {
        return [
            'imageGroupId'   => [
                self::FIELD_RELATION_TO_PARENT => 'ImageGroupModel',
                self::FIELD_SKIP_DUPLICATION   => true,
            ],
            'originalFileId' => [
                self::FIELD_RELATION         => 'FileModel',
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'viewFileId'     => [
                self::FIELD_RELATION         => 'FileModel',
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'thumbFileId'    => [
                self::FIELD_RELATION         => 'FileModel',
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    private function _getFieldsInfoCoordinates()
    {
        return [
            'x1'             => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'y1'             => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'x2'             => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'y2'             => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'thumbX1'        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'thumbY1'        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'thumbX2'        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'thumbY2'        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    private function _getFieldsInfoCommon()
    {
        return [
            'isCover'        => [
                self::FIELD_TYPE             => self::FIELD_TYPE_BOOL,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'sort'           => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'alt'            => [
                self::FIELD_TYPE             => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE            => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'width'          => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'height'         => [
                self::FIELD_TYPE             => self::FIELD_TYPE_INT,
                self::FIELD_VALUE            => [
                    ValueGenerator::MIN => 0,
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'angle'          => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            'flip'           => [
                self::FIELD_TYPE  => self::FIELD_TYPE_INT,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [
                        self::getFlipList(),
                        self::FLIP_NONE
                    ]
                ],
            ],
        ];
    }
}
