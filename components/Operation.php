<?php

namespace testS\components;

use testS\models\BlockModel;

/**
 * Class for work with user from session
 *
 * @package testS\components
 */
class Operation
{

    /**
     * Operation types
     */
    const TYPE_SECTIONS = "SECTIONS";
    const TYPE_BLOCKS = "BLOCKS";
    const TYPE_SETTINGS = "SETTINGS";

    /**
     * All
     */
    const ALL = "ALL";

    /**
     * Section operations
     */
    const SECTION_ADD = "SECTION_ADD";
    const SECTION_UPDATE = "SECTION_UPDATE";
    const SECTION_DESIGN_UPDATE = "SECTION_DESIGN_UPDATE";
    const SECTION_DELETE = "SECTION_DELETE";
    const SECTION_DUPLICATE = "SECTION_DUPLICATE";

    /**
     * Settings operations
     */
    const SETTINGS_ICON = "SETTINGS_ICON";
    const SETTINGS_USER_VIEW = "SETTINGS_USER_VIEW";
    const SETTINGS_USER_UPDATE = "SETTINGS_USER_UPDATE";
    const SETTINGS_USER_DELETE = "SETTINGS_USER_DELETE";
    const SETTINGS_USER_VIEW_SESSIONS = "SETTINGS_USER_VIEW_SESSIONS";
    const SETTINGS_USER_DELETE_SESSIONS = "SETTINGS_USER_DELETE_SESSIONS";
    const SETTINGS_USER_ADD = "SETTINGS_USER_ADD";

    /**
     * Gets section operations
     *
     * @return array
     */
    public static function getSectionOperations()
    {
        return [
            self::SECTION_ADD           => Language::t("operation", "sectionAdd"),
            self::SECTION_UPDATE        => Language::t("operation", "sectionEdit"),
            self::SECTION_DESIGN_UPDATE => Language::t("operation", "sectionEditDesign"),
            self::SECTION_DELETE        => Language::t("operation", "sectionDelete"),
            self::SECTION_DUPLICATE     => Language::t("operation", "sectionDuplicate"),
        ];
    }

    /**
     * Block text operations
     */
    const TEXT_ADD = "TEXT_ADD";
    const TEXT_UPDATE_SETTINGS = "TEXT_UPDATE_SETTINGS";
    const TEXT_UPDATE_DESIGN = "TEXT_UPDATE_DESIGN";
    const TEXT_UPDATE_CONTENT = "TEXT_UPDATE_CONTENT";
    const TEXT_DELETE = "TEXT_DELETE";
    const TEXT_DUPLICATE = "TEXT_DUPLICATE";

    /**
     * Block text operations
     *
     * @var array
     */
    public static $blockTextOperations = [
        self::TEXT_ADD             => "",
        self::TEXT_UPDATE_SETTINGS => "",
        self::TEXT_UPDATE_DESIGN   => "",
        self::TEXT_UPDATE_CONTENT  => "",
        self::TEXT_DELETE          => "",
        self::TEXT_DUPLICATE       => "",
    ];

    /**
     * Gets settings operations
     *
     * @return array
     */
    public static function getSettingsOperations()
    {
        return [
            self::SETTINGS_ICON                 => Language::t("operation", "settingsChangeIcon"),
            self::SETTINGS_USER_VIEW            => Language::t("operation", "settingsViewUsers"),
            self::SETTINGS_USER_UPDATE          => Language::t("operation", "settingsEditUsers"),
            self::SETTINGS_USER_DELETE          => Language::t("operation", "settingsDeleteUsers"),
            self::SETTINGS_USER_VIEW_SESSIONS   => Language::t("operation", "settingsViewUserSessions"),
            self::SETTINGS_USER_DELETE_SESSIONS => Language::t("operation", "settingsDeleteUserSessions"),
            self::SETTINGS_USER_ADD             => Language::t("operation", "settingsAddUsers"),
        ];
    }

    /**
     * Gets a list of content operations by content type
     *
     * @param int $contentType
     *
     * @return array
     */
    public static function getOperationsByContentType($contentType)
    {
        switch ($contentType) {
            case BlockModel::TYPE_TEXT:
                return self::$blockTextOperations;
            default:
                return [];
        }
    }
}