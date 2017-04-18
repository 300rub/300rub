<?php

namespace testS\models;

use testS\components\ValueGenerator;

/**
 * Model for working with table "settings"
 *
 * @package testS\models
 */
class SettingsModel extends AbstractModel
{

    /**
     * Types
     */
    const TYPE_TITLE = "title";
    const TYPE_KEYWORDS = "keywords";
    const TYPE_DESCRIPTION = "description";

    /**
     * Gets a list of types
     *
     * @return array
     */
    public static function getTypeList()
    {
        return [
            self::TYPE_TITLE       => "",
            self::TYPE_KEYWORDS    => "",
            self::TYPE_DESCRIPTION => "",
        ];
    }

    /**
     * Settings
     *
     * @var array
     */
    private static $_settings = [];

    /**
     * Gets table name
     *
     * @return string
     */
    public function getTableName()
    {
        return "settings";
    }

    /**
     * Gets fields info
     *
     * @return array
     */
    public function getFieldsInfo()
    {
        return [
            "type" => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING,
                self::FIELD_VALUE => [
                    ValueGenerator::ARRAY_KEY => [self::getTypeList()]
                ],
            ],
            "value"       => [
                self::FIELD_TYPE => self::FIELD_TYPE_STRING
            ],
        ];
    }

    /**
     * Sets settings
     *
     * @return SettingsModel
     */
    private function _setSettings()
    {
        $settings = $this->findAll();
        foreach ($settings as $setting) {
            self::$_settings[$setting->get("type")] = $setting->get("value");
        }

        return $this;
    }

    /**
     * Gets settings
     *
     * @return array
     */
    public function getSettings()
    {
        if (count(self::$_settings) === 0) {
            $this->_setSettings();
        }

        return self::$_settings;
    }

    /**
     * Gets setting
     *
     * @param string $type
     *
     * @return string|null
     */
    public function getSetting($type = null)
    {
        $settings = $this->getSettings();
        if (!array_key_exists($type, $settings)) {
            return null;
        }

        return $settings[$type];
    }
}