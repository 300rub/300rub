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
                    "id"                          => self::TYPE_PK,
                    "shortCardDesignBlockId"      => self::TYPE_FK,
                    "shortCardLabelDesignBlockId" => self::TYPE_FK,
                    "shortCardLabelDesignTextId"  => self::TYPE_FK,
                    "shortCardValueDesignBlockId" => self::TYPE_FK,
                    "shortCardValueDesignTextId"  => self::TYPE_FK,
                    "fullCardDesignBlockId"       => self::TYPE_FK,
                    "fullCardLabelDesignBlockId"  => self::TYPE_FK,
                    "fullCardLabelDesignTextId"   => self::TYPE_FK,
                    "fullCardValueDesignBlockId"  => self::TYPE_FK,
                    "fullCardValueDesignTextId"   => self::TYPE_FK,
                ]
            )
            ->createForeignKey("designFields", "shortCardDesignBlockId", "designBlocks")
            ->createForeignKey("designFields", "shortCardLabelDesignBlockId", "designBlocks")
            ->createForeignKey("designFields", "shortCardLabelDesignTextId", "designTexts")
            ->createForeignKey("designFields", "shortCardValueDesignBlockId", "designBlocks")
            ->createForeignKey("designFields", "shortCardValueDesignTextId", "designTexts")
            ->createForeignKey("designFields", "fullCardDesignBlockId", "designBlocks")
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
                "fieldInstances",
                [
                    "id"             => self::TYPE_PK,
                    "fieldsId"       => self::TYPE_FK,
                    "sort"           => self::TYPE_SMALLINT,
                    "label"          => self::TYPE_STRING,
                    "type"           => self::TYPE_TINYINT_UNSIGNED,
                    "validationType" => self::TYPE_TINYINT_UNSIGNED,
                    "isHideForShort" => self::TYPE_BOOL,
                    "isShowEmpty"    => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey("fieldInstances", "fieldsId", "fields")
            ->createIndex("fieldInstances", "sort")
            ->createTable(
                "fieldGroups",
                [
                    "id" => self::TYPE_PK,
                ]
            )
            ->createTable(
                "fieldValues",
                [
                    "id"              => self::TYPE_PK,
                    "fieldGroupId"    => self::TYPE_FK,
                    "fieldInstanceId" => self::TYPE_FK,
                    "value"           => self::TYPE_STRING,
                ]
            )
            ->createForeignKey("fieldValues", "fieldGroupId", "fieldGroups")
            ->createForeignKey("fieldValues", "fieldInstanceId", "fieldInstances")
            ->createIndex("fieldValues", "value")
            ->createTable(
                "fieldListValues",
                [
                    "id"              => self::TYPE_PK,
                    "fieldInstanceId" => self::TYPE_FK,
                    "value"           => self::TYPE_STRING,
                    "sort"            => self::TYPE_SMALLINT,
                    "isChecked"       => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey("fieldListValues", "fieldInstanceId", "fieldInstances")
            ->createIndex("fieldListValues", "sort");
    }
}