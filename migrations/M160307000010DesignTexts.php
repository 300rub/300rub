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
                "id"            => "pk",
                "size"          => "integer",
                "family"        => "integer",
                "color"         => "string",
                "isItalic"      => "boolean",
                "isBold"        => "boolean",
                "align"         => "integer",
                "decoration"    => "integer",
                "transform"     => "integer",
                "letterSpacing" => "integer",
                "lineHeight"    => "integer",
            ]
        );
    }
}