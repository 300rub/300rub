<?php

namespace ss\controllers\record;

use ss\application\components\user\Operation;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;

/**
 * Deletes clone block
 */
class DeleteCloneBlockController extends AbstractController
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
                'recordBlockId' => [self::TYPE_INT, self::NOT_EMPTY],
                'id'            => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_RECORD,
            $this->get('recordBlockId'),
            Operation::RECORD_DELETE_CLONE
        );

        $blockModel = BlockModel::model()->getById($this->get('id'));

        if ($blockModel->get('contentType') !== BlockModel::TYPE_RECORD_CLONE) {
            throw new BadRequestException(
                'Incorrect record clone block to delete. ' .
                'ID: {id}. Block type: {type}',
                [
                    'id'   => $this->get('id'),
                    'type' => $blockModel->get('contentType'),
                ]
            );
        }

        $blockModel->delete();

        return $this->getSimpleSuccessResult();
    }
}
