<?php

namespace ss\controllers\record;

use ss\application\components\Operation;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;

/**
 * Duplicates clone record
 */
class CreateCloneBlockDuplicationController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     *
     * @throws BadRequestException
     */
    public function run()
    {
        $this->checkData(
            [
                'recordBlockId'  => [self::TYPE_INT, self::NOT_EMPTY],
                'id'             => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_RECORD,
            $this->get('recordBlockId'),
            Operation::RECORD_DUPLICATE
        );

        $blockModel = BlockModel::model()->getById($this->get('id'));
        if ($blockModel->get('contentType') !== BlockModel::TYPE_RECORD_CLONE) {
            throw new BadRequestException(
                'Incorrect record clone block to duplicate. ' .
                'ID: {id}. Block type: {type}',
                [
                    'id'   => $this->get('id'),
                    'type' => $blockModel->get('contentType'),
                ]
            );
        }

        return [
            'id' => $blockModel->duplicate()->getId()
        ];
    }
}
