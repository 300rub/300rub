<?php

namespace ss\controllers\record;

use ss\application\components\Operation;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;

/**
 * Deletes block
 */
class DeleteBlockController extends AbstractController
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
                'id' => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_RECORD,
            $this->get('id'),
            Operation::RECORD_DELETE
        );

        $blockModel = BlockModel::model()->getById($this->get('id'));

        if ($blockModel->get('contentType') !== BlockModel::TYPE_RECORD) {
            throw new BadRequestException(
                'Incorrect record block to delete. ' .
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
