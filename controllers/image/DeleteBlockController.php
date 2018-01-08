<?php

namespace testS\controllers\image;

use testS\application\components\Operation;
use testS\application\exceptions\BadRequestException;
use testS\controllers\_abstract\AbstractController;
use testS\models\blocks\block\BlockModel;

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

        return $this->getSimpleSuccessResult();
    }
}
