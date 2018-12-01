<?php

namespace ss\controllers\text;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\application\exceptions\BadRequestException;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractBlockController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\text\TextModel;
use ss\models\user\UserEventModel;

/**
 * Updates block's design
 */
class UpdateDesignController extends AbstractBlockController
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
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_TEXT,
            $this->get('id'),
            Operation::TEXT_UPDATE_DESIGN
        );

        $blockModel = BlockModel::model()
            ->getById($this->get('id'));

        $textModel = $blockModel->getContentModel(
            TextModel::CLASS_NAME
        );

        $textModel->set(
            [
                'designBlockModel' => $this->get('designBlockModel'),
            ]
        );

        $designTextModel = $this->get('designTextModel');
        if ($designTextModel !== null) {
            $textModel->set(
                [
                    'designTextModel' => $this->get('designTextModel'),
                ]
            );
        }

        $textModel->save();

        App::getInstance()->getUser()->writeEvent(
            UserEventModel::CATEGORY_BLOCK_TEXT,
            UserEventModel::TYPE_ADD,
            $this->getBlockDesignChangedEvent($blockModel)
        );

        return $this->getSimpleSuccessResult();
    }
}
