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
                "paddingTop"              => self::TYPE_SMALLINT,
                "paddingRight"            => self::TYPE_SMALLINT,
                "paddingBottom"           => self::TYPE_SMALLINT,
                "paddingLeft"             => self::TYPE_SMALLINT,
                "backgroundColorFrom"     => self::TYPE_STRING_25,
                "backgroundColorTo"       => self::TYPE_STRING_25,
                "gradientDirection"       => self::TYPE_TINYINT,
                "borderTopLeftRadius"     => self::TYPE_SMALLINT,
                "borderTopRightRadius"    => self::TYPE_SMALLINT,
                "borderBottomRightRadius" => self::TYPE_SMALLINT,
                "borderBottomLeftRadius"  => self::TYPE_SMALLINT,
                "borderTopWidth"          => self::TYPE_SMALLINT,
                "borderRightWidth"        => self::TYPE_SMALLINT,
                "borderBottomWidth"       => self::TYPE_SMALLINT,
                "borderLeftWidth"         => self::TYPE_SMALLINT,
                "borderStyle"             => self::TYPE_TINYINT,
                "borderColor"             => self::TYPE_STRING_25
            ]
        );
    }
}