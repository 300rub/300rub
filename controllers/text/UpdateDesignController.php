<?php

namespace ss\controllers\text;

use ss\application\components\Operation;
use ss\application\exceptions\BadRequestException;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\text\TextModel;

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

        $textModel = BlockModel::model()
            ->getById($this->get('id'))
            ->getContentModel(
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
