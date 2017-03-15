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
     * Section operations
     */
    const SECTION_ADD = "SECTION_ADD";
    const SECTION_UPDATE = "SECTION_UPDATE";
    const SECTION_DESIGN_UPDATE = "SECTION_DESIGN_UPDATE";
    const SECTION_DELETE = "SECTION_DELETE";
    const SECTION_DUPLICATE = "SECTION_DUPLICATE";

    /**
     * Setting operations
     */
    const SETTING_SEO = "SETTING_SEO";
    const SETTING_ICON = "SETTING_ICON";

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
    const TEXT_UPDATE = "TEXT_UPDATE";
    const TEXT_DESIGN_UPDATE = "TEXT_DESIGN_UPDATE";
    const TEXT_DELETE = "TEXT_DELETE";
    const TEXT_DUPLICATE = "TEXT_DUPLICATE";

    /**
     * Block text operations
     *
     * @var array
     */
    public static $blockTextOperations = [
        self::TEXT_ADD           => "",
        self::TEXT_UPDATE        => "",
        self::TEXT_DESIGN_UPDATE => "",
        self::TEXT_DELETE        => "",
        self::TEXT_DUPLICATE     => "",
    ];

    /**
     * Settings operations
     *
     * @var array
     */
    public static $settingOperations = [
        self::SETTING_SEO  => "",
        self::SETTING_ICON => "",
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