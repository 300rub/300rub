<?php

namespace ss\controllers\text;

use ss\application\components\user\Operation;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractBlockController;
use ss\models\blocks\block\BlockModel;
use ss\models\user\UserEventModel;

/**
 * Duplicates text block
 */
class CreateBlockDuplicationController extends AbstractBlockController
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
            BlockModel::TYPE_TEXT,
            $this->get('id'),
            Operation::TEXT_DUPLICATE
        );

        $blockModel = BlockModel::model()->getById($this->get('id'));
        if ($blockModel->get('contentType') !== BlockModel::TYPE_TEXT) {
            throw new BadRequestException(
                'Incorrect text block to duplicate. ' .
                'ID: {id}. Block type: {type}',
                [
                    'id'   => $this->get('id'),
                    'type' => $blockModel->get('contentType'),
                ]
            );
        }

        $duplication = $blockModel->duplicate();

        $this->writeBlockDuplicatedEvent(
            UserEventModel::CATEGORY_BLOCK_TEXT,
            $blockModel
        );

        return [
            'id' => $duplication->getId()
        ];
    }
}
