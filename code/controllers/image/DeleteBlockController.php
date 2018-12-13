<?php

namespace ss\controllers\image;

use ss\application\components\user\Operation;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractBlockController;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserEventModel;

/**
 * Deletes block
 */
class DeleteBlockController extends AbstractBlockController
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
            BlockModel::TYPE_IMAGE,
            $this->get('id'),
            Operation::IMAGE_DELETE
        );

        $blockModel = BlockModel::model()->getById($this->get('id'));

        if ($blockModel->get('contentType') !== BlockModel::TYPE_IMAGE) {
            throw new BadRequestException(
                'Incorrect image block to delete. ID: {id}. Block type: {type}',
                [
                    'id'   => $this->get('id'),
                    'type' => $blockModel->get('contentType'),
                ]
            );
        }

        $blockModel->delete();

        $this->writeBlockDeletedEvent(
            UserEventModel::CATEGORY_BLOCK_IMAGE,
            $blockModel
        );

        return $this->getSimpleSuccessResult();
    }
}
