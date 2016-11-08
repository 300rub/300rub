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
                "size"          => self::TYPE_SMALLINT,
                "family"        => self::TYPE_TINYINT,
                "color"         => self::TYPE_STRING_25,
                "isItalic"      => self::TYPE_BOOL,
                "isBold"        => self::TYPE_BOOL,
                "align"         => self::TYPE_TINYINT,
                "decoration"    => self::TYPE_TINYINT,
                "transform"     => self::TYPE_TINYINT,
                "letterSpacing" => self::TYPE_SMALLINT,
                "lineHeight"    => self::TYPE_SMALLINT,
            ]
        );
    }
}