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
     * Block text operations
     */
    const TEXT_ADD = "TEXT_ADD";
    const TEXT_UPDATE_SETTINGS = "TEXT_UPDATE_SETTINGS";
    const TEXT_UPDATE_DESIGN = "TEXT_UPDATE_DESIGN";
    const TEXT_UPDATE_CONTENT = "TEXT_UPDATE_CONTENT";
    const TEXT_DELETE = "TEXT_DELETE";
    const TEXT_DUPLICATE = "TEXT_DUPLICATE";

    /**
     * Block image operations
     */
    const IMAGE_ADD = "IMAGE_ADD";
    const IMAGE_UPLOAD = "IMAGE_UPLOAD";
    const IMAGE_UPDATE = "IMAGE_UPDATE";
    const IMAGE_DELETE = "IMAGE_DELETE";
    const IMAGE_DUPLICATE = "IMAGE_DUPLICATE";
    const IMAGE_UPDATE_SETTINGS = "IMAGE_UPDATE_SETTINGS";
    const IMAGE_UPDATE_DESIGN = "IMAGE_UPDATE_DESIGN";
    const IMAGE_UPDATE_CONTENT = "IMAGE_UPDATE_CONTENT";
    const IMAGE_CREATE_ALBUM = "IMAGE_CREATE_ALBUM";
    const IMAGE_UPDATE_ALBUM = "IMAGE_UPDATE_ALBUM";
    const IMAGE_DELETE_ALBUM = "IMAGE_DELETE_ALBUM";

    /**
     * Block record operations
     */
    const RECORD_ADD = "RECORD_ADD";
    const RECORD_UPDATE_SETTINGS = "RECORD_UPDATE_SETTINGS";
    const RECORD_UPDATE_DESIGN = "RECORD_UPDATE_DESIGN";
    const RECORD_UPDATE_CONTENT = "RECORD_UPDATE_CONTENT";
    const RECORD_DELETE = "RECORD_DELETE";

    /**
     * Gets section operations
     *
     * @param bool $isAll
     *
     * @return array
     */
    public static function getSectionOperations($isAll = false)
    {
        $list = [
            self::SECTION_UPDATE        => Language::t("operation", "edit"),
            self::SECTION_DESIGN_UPDATE => Language::t("operation", "editDesign"),
            self::SECTION_DELETE        => Language::t("operation", "delete"),
            self::SECTION_DUPLICATE     => Language::t("operation", "duplicate"),
        ];

        if ($isAll === true) {
            $list[self::SECTION_ADD] = Language::t("operation", "add");
        }

        return $list;
    }

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
     * Gets block text operations
     *
     * @param bool $isAll
     *
     * @return array
     */
    public static function getBlockTextOperations($isAll = false)
    {
        $list = [
            self::TEXT_UPDATE_SETTINGS => Language::t("operation", "editSettings"),
            self::TEXT_UPDATE_DESIGN   => Language::t("operation", "editDesign"),
            self::TEXT_UPDATE_CONTENT  => Language::t("operation", "edit"),
            self::TEXT_DELETE          => Language::t("operation", "delete"),
            self::TEXT_DUPLICATE       => Language::t("operation", "duplicate"),
        ];

        if ($isAll === true) {
            $list[self::TEXT_ADD] = Language::t("operation", "add");
        }

        return $list;
    }

    /**
     * Gets block image operations
     *
     * @param bool $isAll
     *
     * @return array
     */
    public static function getBlockImageOperations($isAll = false)
    {
        $list = [
            self::IMAGE_UPLOAD          => Language::t("operation", "imageUpload"),
            self::IMAGE_UPDATE          => Language::t("operation", "imageUpdate"),
            self::IMAGE_DELETE          => Language::t("operation", "imageDelete"),
            self::IMAGE_UPDATE_SETTINGS => Language::t("operation", "editSettings"),
            self::IMAGE_UPDATE_DESIGN   => Language::t("operation", "editDesign"),
            self::IMAGE_UPDATE_CONTENT  => Language::t("operation", "edit"),
            self::IMAGE_DUPLICATE       => Language::t("operation", "duplicate"),
            self::IMAGE_UPDATE_ALBUM    => Language::t("image", "updateAlbum"),
            self::IMAGE_CREATE_ALBUM    => Language::t("image", "createAlbum"),
            self::IMAGE_DELETE_ALBUM    => Language::t("image", "deleteAlbum"),
        ];

        if ($isAll === true) {
            $list[self::IMAGE_ADD] = Language::t("operation", "add");
        }

        return $list;
    }

    /**
     * Gets block image operations
     *
     * @param bool $isAll
     *
     * @return array
     */
    public static function getBlockRecordOperations($isAll = false)
    {
        $list = [
            self::RECORD_UPDATE_SETTINGS => Language::t("operation", "editSettings"),
            self::RECORD_UPDATE_DESIGN   => Language::t("operation", "editDesign"),
            self::RECORD_UPDATE_CONTENT  => Language::t("operation", "edit"),
            self::RECORD_DELETE          => Language::t("operation", "delete"),
        ];

        if ($isAll === true) {
            $list[self::RECORD_ADD] = Language::t("operation", "add");
        }

        return $list;
    }

    /**
     * Gets a list of content operations by content type
     *
     * @param int  $contentType
     * @param bool $isAll
     *
     * @return array
     */
    public static function getOperationsByContentType($contentType, $isAll = false)
    {
        switch ($contentType) {
            case BlockModel::TYPE_TEXT:
                return self::getBlockTextOperations($isAll);
            case BlockModel::TYPE_IMAGE:
                return self::getBlockImageOperations($isAll);
            case BlockModel::TYPE_RECORD:
                return self::getBlockRecordOperations($isAll);
            default:
                return [];
        }
    }
}