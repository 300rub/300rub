<?php

namespace ss\models\blocks\record;

use ss\application\components\db\Table;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\_content\AbstractContentRecordCloneModel;

/**
 * Model for working with table "recordClones"
 */
class RecordCloneModel extends AbstractContentRecordCloneModel
{

    /**
     * Class name
     */
    const CLASS_NAME = '\\ss\\models\\blocks\\record\\RecordCloneModel';

    /**
     * Gets new model
     *
     * @return RecordCloneModel
     */
    public static function model()
    {
        return new self;
    }

    /**
     * Gets Record block ID
     *
     * @return int
     */
    public function getRecordBlockId()
    {
        $table = $this->getTable()
            ->addSelect('id', 'blocks', 'id')
            ->setTableName('recordClones')
            ->addJoin(
                Table::JOIN_TYPE_INNER,
                'records',
                'records',
                self::PK_FIELD,
                Table::DEFAULT_ALIAS,
                'recordId'
            )
            ->addJoin(
                Table::JOIN_TYPE_INNER,
                'blocks',
                'blocks',
                'contentId',
                'records',
                self::PK_FIELD
            )
            ->addWhere(
                sprintf(
                    '%s.%s = :id',
                    Table::DEFAULT_ALIAS,
                    self::PK_FIELD
                )
            )
            ->addWhere('blocks.contentType = :contentType')
            ->addParameter('id', $this->getId())
            ->addParameter('contentType', BlockModel::TYPE_RECORD);

        $result = $table->find();
        if (is_array($result) === true
            && array_key_exists('id', $result) === true
        ) {
            return (int)$result['id'];
        }

        return 0;
    }
}
