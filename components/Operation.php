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
    const SETTINGS_USERS_VIEW = "SETTINGS_USERS_VIEW";

    /**
     * Section operations
     *
     * @var array
     */
    public static $sectionOperations = [
        self::SECTION_ADD           => "",
        self::SECTION_UPDATE        => "",
        self::SECTION_DESIGN_UPDATE => "",
        self::SECTION_DELETE        => "",
        self::SECTION_DUPLICATE     => "",
    ];

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
     * Settings operations
     *
     * @var array
     */
    public static $settingOperations = [
        self::SETTINGS_ICON       => "",
        self::SETTINGS_USERS_VIEW => "",
    ];

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