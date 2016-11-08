<?php

namespace testS\migrations;

/**
 * Creates designBlocks table
 *
 * @package testS\migrations
 */
class M160307000020DesignBlocks extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this->createTable(
            "designBlocks",
            [
                "id"                      => self::TYPE_PK,
                "marginTop"               => self::TYPE_SMALLINT,
                "marginRight"             => self::TYPE_SMALLINT,
                "marginBottom"            => self::TYPE_SMALLINT,
                "marginLeft"              => self::TYPE_SMALLINT,
                "paddingTop"              => self::TYPE_SMALLINT_UNSIGNED,
                "paddingRight"            => self::TYPE_SMALLINT_UNSIGNED,
                "paddingBottom"           => self::TYPE_SMALLINT_UNSIGNED,
                "paddingLeft"             => self::TYPE_SMALLINT_UNSIGNED,
                "backgroundColorFrom"     => self::TYPE_STRING_25,
                "backgroundColorTo"       => self::TYPE_STRING_25,
                "gradientDirection"       => self::TYPE_TINYINT,
                "borderTopLeftRadius"     => self::TYPE_SMALLINT_UNSIGNED,
                "borderTopRightRadius"    => self::TYPE_SMALLINT_UNSIGNED,
                "borderBottomRightRadius" => self::TYPE_SMALLINT_UNSIGNED,
                "borderBottomLeftRadius"  => self::TYPE_SMALLINT_UNSIGNED,
                "borderTopWidth"          => self::TYPE_SMALLINT_UNSIGNED,
                "borderRightWidth"        => self::TYPE_SMALLINT_UNSIGNED,
                "borderBottomWidth"       => self::TYPE_SMALLINT_UNSIGNED,
                "borderLeftWidth"         => self::TYPE_SMALLINT_UNSIGNED,
                "borderStyle"             => self::TYPE_TINYINT_UNSIGNED,
                "borderColor"             => self::TYPE_STRING_25
            ]
        );
    }
}