<?php

namespace ss\models\settings\_base;

use ss\application\App;
use ss\application\components\valueGenerator\ValueGenerator;
use ss\models\_abstract\AbstractModel;

/**
 * Abstract model for working with table "settings"
 */
abstract class AbstractSettingsModel extends AbstractModel
{

    /**
     * Types
     */
    const ICON = 'ICON';
    const APPLE_TOUCH_ICON_57 = 'APPLE_TOUCH_ICON_57';
    const CODE_HEADER = 'CODE_HEADER';
    const CODE_BODY_TOP = 'CODE_BODY_TOP';
    const CODE_BODY_BOTTOM = 'CODE_BODY_BOTTOM';

    /**
     * Gets a list of types
     *
     * @return array
     */
    public function getTypeList()
    {
        $language = App::getInstance()->getLanguage();

        return [
            self::ICON
                => '',
            self::APPLE_TOUCH_ICON_57
                => '',
            self::CODE_HEADER
                => $language->getMessage('settings', 'codeHeader'),
            self::CODE_BODY_TOP
                => $language->getMessage('settings', 'codeBodyTop'),
            self::CODE_BODY_BOTTOM
                => $language->getMessage('settings', 'codeBodyBottom'),
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
                    ValueGenerator::ARRAY_KEY => [$this->getTypeList()]
                ],
                self::FIELD_NOT_CHANGE_ON_UPDATE => true,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
            'value'       => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_SKIP_DUPLICATION => true,
            ],
        ];
    }
}
