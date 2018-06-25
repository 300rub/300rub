<?php

namespace ss\migrations;

use ss\migrations\_abstract\AbstractMigration;

/**
 * Creates field tables
 */
class M160321000500Fields extends AbstractMigration
{

    /**
     * Applies migration
     *
     * @return void
     */
    public function apply()
    {
        $this
            ->_createDesignFields()
            ->_createFields()
            ->_createFieldTemplates()
            ->_createFieldGroups()
            ->_createFieldInstances()
            ->_fieldListValues();
    }

    /**
     * Creates designFields table
     *
     * @return M160321000500Fields
     */
    private function _createDesignFields()
    {
        return $this
            ->createTable(
                'designFields',
                [
                    'id'                              => self::TYPE_PK,
                    'shortCardContainerDesignBlockId' => self::TYPE_FK,
                    'shortCardLabelDesignBlockId'     => self::TYPE_FK,
                    'shortCardLabelDesignTextId'      => self::TYPE_FK,
                    'shortCardValueDesignBlockId'     => self::TYPE_FK,
                    'shortCardValueDesignTextId'      => self::TYPE_FK,
                    'fullCardContainerDesignBlockId'  => self::TYPE_FK,
                    'fullCardLabelDesignBlockId'      => self::TYPE_FK,
                    'fullCardLabelDesignTextId'       => self::TYPE_FK,
                    'fullCardValueDesignBlockId'      => self::TYPE_FK,
                    'fullCardValueDesignTextId'       => self::TYPE_FK,
                ]
            )
            ->createForeignKey(
                'designFields',
                'shortCardContainerDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designFields',
                'shortCardLabelDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designFields',
                'shortCardLabelDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designFields',
                'shortCardValueDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designFields',
                'shortCardValueDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designFields',
                'fullCardContainerDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designFields',
                'fullCardLabelDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designFields',
                'fullCardLabelDesignTextId',
                'designTexts'
            )
            ->createForeignKey(
                'designFields',
                'fullCardValueDesignBlockId',
                'designBlocks'
            )
            ->createForeignKey(
                'designFields',
                'fullCardValueDesignTextId',
                'designTexts'
            );
    }

    /**
     * Creates fields table
     *
     * @return M160321000500Fields
     */
    private function _createFields()
    {
        return $this
            ->createTable(
                'fields',
                [
                    'id'            => self::TYPE_PK,
                    'designFieldId' => self::TYPE_FK,
                ]
            )
            ->createForeignKey('fields', 'designFieldId', 'designFields');
    }

    /**
     * Creates fieldTemplates table
     *
     * @return M160321000500Fields
     */
    private function _createFieldTemplates()
    {
        return $this
            ->createTable(
                'fieldTemplates',
                [
                    'id'                 => self::TYPE_PK,
                    'fieldId'            => self::TYPE_FK,
                    'sort'               => self::TYPE_SMALLINT,
                    'label'              => self::TYPE_STRING,
                    'type'               => self::TYPE_TINYINT_UNSIGNED,
                    'validationType'     => self::TYPE_TINYINT_UNSIGNED,
                    'isHideForShortCard' => self::TYPE_BOOL,
                    'isShowEmpty'        => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey(
                'fieldTemplates',
                'fieldId',
                'fields',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createIndex('fieldTemplates', 'sort');
    }

    /**
     * Creates fieldGroups table
     *
     * @return M160321000500Fields
     */
    private function _createFieldGroups()
    {
        return $this
            ->createTable(
                'fieldGroups',
                [
                    'id'      => self::TYPE_PK,
                    'fieldId' => self::TYPE_FK,
                ]
            )
            ->createForeignKey('fieldGroups', 'fieldId', 'fields');
    }

    /**
     * Creates fieldInstances table
     *
     * @return M160321000500Fields
     */
    private function _createFieldInstances()
    {
        return $this
            ->createTable(
                'fieldInstances',
                [
                    'id'              => self::TYPE_PK,
                    'fieldGroupId'    => self::TYPE_FK,
                    'fieldTemplateId' => self::TYPE_FK,
                    'value'           => self::TYPE_STRING,
                ]
            )
            ->createForeignKey(
                'fieldInstances',
                'fieldGroupId',
                'fieldGroups',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createForeignKey(
                'fieldInstances',
                'fieldTemplateId',
                'fieldTemplates',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createIndex('fieldInstances', 'value');
    }

    /**
     * Creates fieldListValues table
     *
     * @return M160321000500Fields
     */
    private function _fieldListValues()
    {
        return $this
            ->createTable(
                'fieldListValues',
                [
                    'id'              => self::TYPE_PK,
                    'fieldTemplateId' => self::TYPE_FK,
                    'value'           => self::TYPE_STRING,
                    'sort'            => self::TYPE_SMALLINT,
                    'isChecked'       => self::TYPE_BOOL,
                ]
            )
            ->createForeignKey(
                'fieldListValues',
                'fieldTemplateId',
                'fieldTemplates',
                self::FK_CASCADE,
                self::FK_CASCADE
            )
            ->createIndex('fieldListValues', 'sort');
    }
}
