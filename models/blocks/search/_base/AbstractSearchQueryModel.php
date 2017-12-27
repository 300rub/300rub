<?php

namespace testS\models\blocks\search\_base;

use testS\application\components\Validator;
use testS\application\components\ValueGenerator;
use testS\models\blocks\search\_abstract\AbstractSearchModel;

/**
 * Abstract model for working with table "searchQueries"
 */
abstract class AbstractSearchQueryModel extends AbstractSearchModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'searchQueries';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'searchId'   => [
                self::FIELD_RELATION_TO_PARENT => 'SearchModel',
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'text'       => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'date'       => [
                self::FIELD_TYPE => self::FIELD_TYPE_DATETIME,
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'ip'         => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_IP
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'ua'         => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'uri'       => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'ref'        => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }
}
