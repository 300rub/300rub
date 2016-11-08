<?php

namespace testS\migrations;

/**
 * Creates designTexts table
 *
 * @package testS\migrations
 */
class M160307000010DesignTexts extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this->createTable(
            "designTexts",
            [
                "id"            => self::TYPE_PK,
                "size"          => self::TYPE_SMALLINT_UNSIGNED,
                "family"        => self::TYPE_TINYINT_UNSIGNED,
                "color"         => self::TYPE_STRING_25,
                "isItalic"      => self::TYPE_BOOL,
                "isBold"        => self::TYPE_BOOL,
                "align"         => self::TYPE_TINYINT_UNSIGNED,
                "decoration"    => self::TYPE_TINYINT_UNSIGNED,
                "transform"     => self::TYPE_TINYINT_UNSIGNED,
                "letterSpacing" => self::TYPE_SMALLINT,
                "lineHeight"    => self::TYPE_SMALLINT_UNSIGNED,
            ]
        );
    }
}