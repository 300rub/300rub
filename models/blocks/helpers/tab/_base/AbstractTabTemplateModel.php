<?php

namespace testS\models\blocks\helpers\tab\_base;

use testS\application\components\ValueGenerator;
use testS\application\components\Validator;
use testS\models\blocks\helpers\tab\_abstract\AbstractTabModel;

/**
 * Model for working with table "tabTemplates"
 */
abstract class AbstractTabTemplateModel extends AbstractTabModel
{

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'tabTemplates';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'tabId' => [
                self::FIELD_RELATION_TO_PARENT
                    => '\\testS\\models\\blocks\\helpers\\tab\\TabModel',
            ],
            'sort'  => [
                self::FIELD_TYPE => self::FIELD_TYPE_INT,
            ],
            'label' => [
                self::FIELD_TYPE       => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_MAX_LENGTH => 255,
                ],
                self::FIELD_VALUE      => [
                    ValueGenerator::CLEAR_STRIP_TAGS
                ],
            ],
        ];
    }
}
