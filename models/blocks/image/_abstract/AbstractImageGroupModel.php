<?php

namespace testS\models\blocks\image\_abstract;

use testS\application\components\Validator;
use testS\application\components\ValueGenerator;
use testS\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "imageGroups"
 */
abstract class AbstractImageGroupModel extends AbstractModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'imageGroups';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'imageId' => [
                self::FIELD_RELATION_TO_PARENT => 'ImageModel',
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
            ],
            'name'    => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
            'sort'    => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
        ];
    }
}
