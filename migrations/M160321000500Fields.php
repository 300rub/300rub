<?php

namespace testS\migrations;

/**
 * Creates field tables
 *
 * @package testS\migrations
 */
class M160321000500Fields extends AbstractMigration
{

    /**
     * Applies migration
     */
    public function up()
    {
        $this
            ->createTable(
                "designFields",
                [
                    "id"                              => self::TYPE_PK,
                    "shortCardContainerDesignBlockId" => self::TYPE_FK,
                    "shortCardLabelDesignBlockId"     => self::TYPE_FK,
                    "shortCardLabelDesignTextId"      => self::TYPE_FK,
                    "shortCardValueDesignBlockId"     => self::TYPE_FK,
                    "shortCardValueDesignTextId"      => self::TYPE_FK,
                    "fullCardContainerDesignBlockId"  => self::TYPE_FK,
                    "fullCardLabelDesignBlockId"      => self::TYPE_FK,
                    "fullCardLabelDesignTextId"       => self::TYPE_FK,
                    "fullCardValueDesignBlockId"      => self::TYPE_FK,
                    "fullCardValueDesignTextId"       => self::TYPE_FK,
                ]
            )
            ->createForeignKey("designFields", "shortCardContainerDesignBlockId", "designBlocks")
            ->createForeignKey("designFields", "shortCardLabelDesignBlockId", "designBlocks")
            ->createForeignKey("designFields", "shortCardLabelDesignTextId", "designTexts")
            ->createForeignKey("designFields", "shortCardValueDesignBlockId", "designBlocks")
            ->createForeignKey("designFields", "shortCardValueDesignTextId", "designTexts")
            ->createForeignKey("designFields", "fullCardContainerDesignBlockId", "designBlocks")
            ->createForeignKey("designFields", "fullCardLabelDesignBlockId", "designBlocks")
            ->createForeignKey("designFields", "fullCardLabelDesignTextId", "designTexts")
            ->createForeignKey("designFields", "fullCardValueDesignBlockId", "designBlocks")
            ->createForeignKey("designFields", "fullCardValueDesignTextId", "designTexts")
            ->createTable(
                "fields",
                [
                    "id"            => self::TYPE_PK,
                    "designFieldId" => self::TYPE_FK,
                ]
            )
            ->createForeignKey("fields", "designFieldId", "designFields")
            ->createTable(
                "fieldTemplates",
                [
                    "id"                 => self::TYPE_PK,
                    "fieldId"            => self::TYPE_FK,
                    "sort"               => self::TYPE_SMALLINT,
                    "label"              => self::TYPE_STRING,
                    "type"               => self::TYPE_TINYINT_UNSIGNED,
                    "validationType"     => self::TYPE_TINYINT_UNSIGNED,
                    "isHideForShortCard" => self::TYPE_BOOL,
                    "isShowEmpty"        => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey("fieldTemplates", "fieldId", "fields", self::FK_CASCADE, self::FK_CASCADE)
            ->createIndex("fieldTemplates", "sort")
            ->createTable(
                "fieldGroups",
                [
                    "id"      => self::TYPE_PK,
                    "fieldId" => self::TYPE_FK,
                ]
            )
            ->createForeignKey("fieldGroups", "fieldId", "fields")
            ->createTable(
                "fieldInstances",
                [
                    "id"              => self::TYPE_PK,
                    "fieldGroupId"    => self::TYPE_FK,
                    "fieldTemplateId" => self::TYPE_FK,
                    "value"           => self::TYPE_STRING,
                ]
            )
            ->createForeignKey("fieldInstances", "fieldGroupId", "fieldGroups", self::FK_CASCADE, self::FK_CASCADE)
            ->createForeignKey(
                "fieldInstances",
                "fieldTemplateId",
                "fieldInstances",
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createIndex("fieldInstances", "value")
            ->createTable(
                "fieldListValues",
                [
                    "id"              => self::TYPE_PK,
                    "fieldTemplateId" => self::TYPE_FK,
                    "value"           => self::TYPE_STRING,
                    "sort"            => self::TYPE_SMALLINT,
                    "isChecked"       => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey(
                "fieldListValues",
                "fieldTemplateId",
                "fieldTemplates",
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createIndex("fieldListValues", "sort");
    }
}