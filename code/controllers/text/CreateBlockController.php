<?php

namespace ss\controllers\text;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\application\exceptions\BadRequestException;
use ss\controllers\_abstract\AbstractBlockController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\text\TextInstanceModel;
use ss\models\blocks\text\TextModel;
use ss\models\user\UserEventModel;

/**
 * Adds block
 */
class CreateBlockController extends AbstractBlockController
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
        $this->checkBlockOperation(
            BlockModel::TYPE_TEXT,
            Operation::ALL,
            Operation::TEXT_ADD
        );

        $this->checkData(
            [
                'name'      => [self::TYPE_STRING],
                'type'      => [self::TYPE_INT],
                'hasEditor' => [self::TYPE_BOOL],
            ]
        );

        $textModel = new TextModel();
        $textModel->set(
            [
                'type'      => $this->get('type'),
                'hasEditor' => $this->get('hasEditor'),
            ]
        );
        $textModel->save();

        $textInstanceModel = new TextInstanceModel();
        $textInstanceModel->set(
            [
                'textId' => $textModel->getId()
            ]
        );
        $textInstanceModel->save();

        $blockModel = new BlockModel();
        $blockModel->set(
            [
                'name'        => $this->get('name'),
                'language'
                    => App::getInstance()->getLanguage()->getActiveId(),
                'contentType' => BlockModel::TYPE_TEXT,
                'contentId'   => $textModel->getId(),
            ]
        );
        $blockModel->save();

        $errors = $blockModel->getParsedErrors();
        if (count($errors) > 0) {
            $this->removeSavedData();

            return [
                'errors' => $errors
            ];
        }

        $this->writeBlockCreatedEvent(
            UserEventModel::CATEGORY_BLOCK_TEXT,
            $blockModel
        );

        return $this->getSimpleSuccessResult();
    }
}
