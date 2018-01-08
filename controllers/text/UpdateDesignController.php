<?php

namespace testS\controllers\text;

use testS\application\components\Operation;
use testS\application\exceptions\BadRequestException;
use testS\application\exceptions\NotFoundException;
use testS\controllers\_abstract\AbstractController;
use testS\models\blocks\block\BlockModel;
use testS\models\blocks\text\TextModel;

/**
 * Updates block's design
 */
class UpdateDesignController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     *
     * @throws BadRequestException
     * @throws NotFoundException
     */
    public function run()
    {
        $this->checkData(
            [
                'id'               => [self::TYPE_INT, self::NOT_EMPTY],
                'designBlockModel' => [self::TYPE_ARRAY, self::NOT_EMPTY],
                'designTextModel'  => [self::TYPE_ARRAY, self::NOT_EMPTY],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_TEXT,
            $this->get('id'),
            Operation::TEXT_UPDATE_DESIGN
        );

        $blockModel = new BlockModel();
        $blockModel = $blockModel->getById($this->get('id'));
        $textModel = $blockModel->getContentModel(
            false,
            null,
            TextModel::CLASS_NAME
        );

        $textModel->set(
            [
                'designTextModel'  => $this->get('designTextModel'),
                'designBlockModel' => $this->get('designBlockModel'),
            ]
        );
        $textModel->save();

        return $this->getSimpleSuccessResult();
    }
}
