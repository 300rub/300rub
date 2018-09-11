<?php

namespace ss\controllers\text;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractBlockController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\text\TextModel;
use ss\models\user\UserEventModel;

/**
 * Updates block
 */
class UpdateBlockController extends AbstractBlockController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkData(
            [
                'id'        => [self::TYPE_INT, self::NOT_EMPTY],
                'name'      => [self::TYPE_STRING],
                'type'      => [self::TYPE_INT],
                'hasEditor' => [self::TYPE_BOOL],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_TEXT,
            $this->get('id'),
            Operation::TEXT_UPDATE_SETTINGS
        );

        $blockModel = BlockModel::model()->getById($this->get('id'));
        $oldBlock = clone $blockModel;

        $textModel = $blockModel->getContentModel(
            TextModel::CLASS_NAME
        );
        $textModel->set(
            [
                'type'      => $this->get('type'),
                'hasEditor' => $this->get('hasEditor'),
            ]
        );
        $textModel->save();

        $blockModel->set(
            [
                'name' => $this->get('name'),
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

        $blockModel->setContent();

        App::getInstance()->getUser()->writeEvent(
            UserEventModel::CATEGORY_BLOCK_TEXT,
            UserEventModel::TYPE_ADD,
            $this->getBlockSettingsUpdatedEvent(
                $oldBlock,
                $blockModel
            )
        );

        return [
            'result' => true,
            'html'   => $blockModel->getHtml(),
            'css'    => $blockModel->getCss(),
            'js'     => $blockModel->getJs(),
        ];
    }
}
