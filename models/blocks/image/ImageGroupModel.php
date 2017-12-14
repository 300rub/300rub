<?php

namespace testS\models;

use testS\components\Db;
use testS\components\Validator;
use testS\components\ValueGenerator;

/**
 * Model for working with table "imageGroups"
 *
 * @package testS\models
 */
class ImageGroupModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "imageGroups";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "imageId" => [
                self::FIELD_RELATION_TO_PARENT => "ImageModel",
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            "name"    => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            "sort"    => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
        ];
    }

    /**
     * Adds imageId condition to SQL request
     *
     * @param int $imageId
     *
     * @return ImageGroupModel
     */
    public function byImageId($imageId)
    {
        $this->getDb()->addWhere(sprintf("%s.imageId = :imageId", Db::DEFAULT_ALIAS));
        $this->getDb()->addParameter("imageId", (int) $imageId);

        return $this;
    }
}