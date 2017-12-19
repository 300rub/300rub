<?php

namespace testS\migrations;

use testS\migrations\_abstract\AbstractMigration;

/**
 * Creates designTexts table
 */
class M160302000020DesignTexts extends AbstractMigration
{

    /**
     * Applies migration
     *
     * @return void
     */
    public function apply()
    {
        $this->createTable(
            'designTexts',
            [
                'id'                 => self::TYPE_PK,
                'size'               => self::TYPE_SMALLINT_UNSIGNED,
                'sizeHover'          => self::TYPE_SMALLINT_UNSIGNED,
                'family'             => self::TYPE_TINYINT_UNSIGNED,
                'color'              => self::TYPE_STRING_25,
                'colorHover'         => self::TYPE_STRING_25,
                'isItalic'           => self::TYPE_BOOL,
                'isItalicHover'      => self::TYPE_BOOL,
                'isBold'             => self::TYPE_BOOL,
                'isBoldHover'        => self::TYPE_BOOL,
                'align'              => self::TYPE_TINYINT_UNSIGNED,
                'decoration'         => self::TYPE_TINYINT_UNSIGNED,
                'decorationHover'    => self::TYPE_TINYINT_UNSIGNED,
                'transform'          => self::TYPE_TINYINT_UNSIGNED,
                'transformHover'     => self::TYPE_TINYINT_UNSIGNED,
                'letterSpacing'      => self::TYPE_SMALLINT,
                'letterSpacingHover' => self::TYPE_SMALLINT,
                'lineHeight'         => self::TYPE_SMALLINT_UNSIGNED,
                'lineHeightHover'    => self::TYPE_SMALLINT,
                'hasHover'           => self::TYPE_BOOL,
            ]
        );
    }
}
