<?php

namespace testS\components;

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
     * Section operations
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
        self::SECTION_ADD           => "",
        self::SECTION_UPDATE        => "",
        self::SECTION_DESIGN_UPDATE => "",
        self::SECTION_DELETE        => "",
    ];
}