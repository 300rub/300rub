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
                "designForms",
                [
                    "id"                     => self::TYPE_PK,
                    "designBlockId"          => self::TYPE_FK,
                    "lineDesignBlockId"      => self::TYPE_FK,
                    "labelDesignBlockId"     => self::TYPE_FK,
                    "labelDesignTextId"      => self::TYPE_FK,
                    "formDesignBlockId"      => self::TYPE_FK,
                    "formDesignTextId"       => self::TYPE_FK,
                    "submitDesignBlockId"    => self::TYPE_FK,
                    "submitDesignTextId"     => self::TYPE_FK,
                    "submitIconDesignTextId" => self::TYPE_FK,
                    "submitIcon"             => self::TYPE_STRING_50,
                    "submitIconPosition"     => self::TYPE_TINYINT_UNSIGNED,
                    "submitAlignment"        => self::TYPE_TINYINT_UNSIGNED,
                ]
            )
            ->createForeignKey("designForms", "designBlockId", "designBlocks")
            ->createForeignKey("designForms", "lineDesignBlockId", "designBlocks")
            ->createForeignKey("designForms", "labelDesignBlockId", "designBlocks")
            ->createForeignKey("designForms", "labelDesignTextId", "designTexts")
            ->createForeignKey("designForms", "formDesignBlockId", "designBlocks")
            ->createForeignKey("designForms", "formDesignTextId", "designTexts")
            ->createForeignKey("designForms", "submitDesignBlockId", "designBlocks")
            ->createForeignKey("designForms", "submitDesignTextId", "designTexts")
            ->createForeignKey("designForms", "submitIconDesignTextId", "designTexts")
            ->createTable(
                "forms",
                [
                    "id"           => self::TYPE_PK,
                    "designFormId" => self::TYPE_FK,
                    "hasLabel"     => self::TYPE_BOOL,
                    "successText"  => self::TYPE_STRING,
                ]
            )
            ->createForeignKey("forms", "designFormId", "designForms")
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