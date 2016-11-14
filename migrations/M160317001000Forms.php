<?php

namespace testS\migrations;

/**
 * Creates forms tables
 *
 * @package testS\migrations
 */
class M160317001000Forms extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "forms",
                [
                    "id"                  => self::TYPE_PK,
                    "designBlockId"       => self::TYPE_FK,
                    "lineDesignBlockId"   => self::TYPE_FK,
                    "labelDesignBlockId"  => self::TYPE_FK,
                    "labelDesignTextId"   => self::TYPE_FK,
                    "formDesignBlockId"   => self::TYPE_FK,
                    "formDesignTextId"    => self::TYPE_FK,
                    "submitDesignBlockId" => self::TYPE_FK,
                    "submitDesignTextId"  => self::TYPE_FK,
                    "buttonAlignment"     => self::TYPE_TINYINT_UNSIGNED,
                    "hasLabel"            => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey("forms", "designBlockId", "designBlocks")
            ->createForeignKey("forms", "lineDesignBlockId", "designBlocks")
            ->createForeignKey("forms", "labelDesignBlockId", "designBlocks")
            ->createForeignKey("forms", "labelDesignTextId", "designTexts")
            ->createForeignKey("forms", "formDesignBlockId", "designBlocks")
            ->createForeignKey("forms", "formDesignTextId", "designTexts")
            ->createForeignKey("forms", "submitDesignBlockId", "designBlocks")
            ->createForeignKey("forms", "submitDesignTextId", "designTexts")
            ->createTable(
                "formElements",
                [
                    "id"             => self::TYPE_PK,
                    "formId"         => self::TYPE_FK,
                    "sort"           => self::TYPE_SMALLINT,
                    "label"          => self::TYPE_STRING,
                    "isRequired"     => self::TYPE_BOOL,
                    "validationType" => self::TYPE_INT_UNSIGNED,
                    "type"           => self::TYPE_INT_UNSIGNED,
                ]
            )
            ->createForeignKey("formElements", "formId", "forms", self::FK_CASCADE, self::FK_CASCADE)
            ->createIndex("formElements", "sort")
            ->createTable(
                "formValues",
                [
                    "id"            => self::TYPE_PK,
                    "formElementId" => self::TYPE_FK,
                    "sort"          => self::TYPE_SMALLINT,
                    "value"         => self::TYPE_STRING,
                    "isChecked"     => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey("formValues", "formElementId", "formElements", self::FK_CASCADE, self::FK_CASCADE)
            ->createIndex("formValues", "sort");
    }
}