<?php

namespace testS\models\settings\_abstract;

use testS\application\components\Validator;
use testS\application\components\ValueGenerator;
use testS\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "settings"
 */
abstract class AbstractSettingsModel extends AbstractModel
{

    /**
     * Types
     */
    const ICON = 'icon';
    const APPLE_TOUCH_ICON_57 = 'appleTouchIcon57';

    /**
     * Gets a list of types
     *
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::ICON                => '',
            self::APPLE_TOUCH_ICON_57 => '',
        ];
    }

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return 'settings';
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            'type' => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::getTypeList()]
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'value'       => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_VALIDATION => [
                    Validator::TYPE_REQUIRED,
                    Validator::TYPE_MAX_LENGTH => 255
                ],
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }
}
