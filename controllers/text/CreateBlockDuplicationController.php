<?php

namespace testS\controllers\text;

use testS\application\components\Operation;
use testS\application\exceptions\BadRequestException;
use testS\controllers\_abstract\AbstractController;
use testS\models\blocks\block\BlockModel;

/**
 * Duplicates text block
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
            BlockModel::TYPE_TEXT,
            $this->get('id'),
            Operation::TEXT_DUPLICATE
        );

        $blockModel = new BlockModel();
        $blockModel = $blockModel->getById($this->get('id'));
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

        return [
            'id' => $duplication->getId()
        ];
    }
}
