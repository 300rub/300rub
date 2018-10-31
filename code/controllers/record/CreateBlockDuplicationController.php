<?php

namespace ss\controllers\record;

use ss\application\components\user\Operation;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;

/**
 * Duplicates record
 */
class CreateBlockDuplicationController extends AbstractController
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
            Operation::RECORD_DUPLICATE
        );

        $blockModel = BlockModel::model()->getById($this->get('id'));
        if ($blockModel->get('contentType') !== BlockModel::TYPE_RECORD) {
            throw new BadRequestException(
                'Incorrect record block to duplicate. ' .
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
