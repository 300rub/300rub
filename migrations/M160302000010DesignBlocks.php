<?php

namespace testS\migrations;

/**
 * Creates designBlocks table
 *
 * @package testS\migrations
 */
class M160302000010DesignBlocks extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this->createTable(
            "designBlocks",
            [
                "id"                           => self::TYPE_PK,
                "marginTop"                    => self::TYPE_SMALLINT,
                "marginTopHover"               => self::TYPE_SMALLINT,
                "marginRight"                  => self::TYPE_SMALLINT,
                "marginRightHover"             => self::TYPE_SMALLINT,
                "marginBottom"                 => self::TYPE_SMALLINT,
                "marginBottomHover"            => self::TYPE_SMALLINT,
                "marginLeft"                   => self::TYPE_SMALLINT,
                "marginLeftHover"              => self::TYPE_SMALLINT,
                "hasMarginHover"               => self::TYPE_BOOL,
                "hasMarginAnimation"           => self::TYPE_BOOL,
                "paddingTop"                   => self::TYPE_SMALLINT_UNSIGNED,
                "paddingTopHover"              => self::TYPE_SMALLINT_UNSIGNED,
                "paddingRight"                 => self::TYPE_SMALLINT_UNSIGNED,
                "paddingRightHover"            => self::TYPE_SMALLINT_UNSIGNED,
                "paddingBottom"                => self::TYPE_SMALLINT_UNSIGNED,
                "paddingBottomHover"           => self::TYPE_SMALLINT_UNSIGNED,
                "paddingLeft"                  => self::TYPE_SMALLINT_UNSIGNED,
                "paddingLeftHover"             => self::TYPE_SMALLINT_UNSIGNED,
                "hasPaddingHover"              => self::TYPE_BOOL,
                "hasPaddingAnimation"          => self::TYPE_BOOL,
                "backgroundColorFrom"          => self::TYPE_STRING_25,
                "backgroundColorFromHover"     => self::TYPE_STRING_25,
                "backgroundColorTo"            => self::TYPE_STRING_25,
                "backgroundColorToHover"       => self::TYPE_STRING_25,
                "gradientDirection"            => self::TYPE_TINYINT_UNSIGNED,
                "gradientDirectionHover"       => self::TYPE_TINYINT_UNSIGNED,
                "hasBackgroundGradient"        => self::TYPE_BOOL,
                "hasBackgroundHover"           => self::TYPE_BOOL,
                "hasBackgroundAnimation"       => self::TYPE_BOOL,
                "borderTopLeftRadius"          => self::TYPE_SMALLINT_UNSIGNED,
                "borderTopLeftRadiusHover"     => self::TYPE_SMALLINT_UNSIGNED,
                "borderTopRightRadius"         => self::TYPE_SMALLINT_UNSIGNED,
                "borderTopRightRadiusHover"    => self::TYPE_SMALLINT_UNSIGNED,
                "borderBottomRightRadius"      => self::TYPE_SMALLINT_UNSIGNED,
                "borderBottomRightRadiusHover" => self::TYPE_SMALLINT_UNSIGNED,
                "borderBottomLeftRadius"       => self::TYPE_SMALLINT_UNSIGNED,
                "borderBottomLeftRadiusHover"  => self::TYPE_SMALLINT_UNSIGNED,
                "borderTopWidth"               => self::TYPE_SMALLINT_UNSIGNED,
                "borderTopWidthHover"          => self::TYPE_SMALLINT_UNSIGNED,
                "borderRightWidth"             => self::TYPE_SMALLINT_UNSIGNED,
                "borderRightWidthHover"        => self::TYPE_SMALLINT_UNSIGNED,
                "borderBottomWidth"            => self::TYPE_SMALLINT_UNSIGNED,
                "borderBottomWidthHover"       => self::TYPE_SMALLINT_UNSIGNED,
                "borderLeftWidth"              => self::TYPE_SMALLINT_UNSIGNED,
                "borderLeftWidthHover"         => self::TYPE_SMALLINT_UNSIGNED,
                "borderStyle"                  => self::TYPE_TINYINT_UNSIGNED,
                "borderStyleHover"             => self::TYPE_TINYINT_UNSIGNED,
                "borderColor"                  => self::TYPE_STRING_25,
                "borderColorHover"             => self::TYPE_STRING_25,
                "hasBorderHover"               => self::TYPE_BOOL,
                "hasBorderAnimation"           => self::TYPE_BOOL,
                "width"                        => self::TYPE_SMALLINT_UNSIGNED,
            ]
        );
    }
}