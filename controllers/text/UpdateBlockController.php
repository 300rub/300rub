<?php

namespace ss\controllers\text;

use ss\application\components\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\text\TextModel;

/**
 * Updates block
 */
class UpdateBlockController extends AbstractController
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

        $textModel = $blockModel->getContentModel(
            null,
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

        return [
            'result' => true,
            'html'   => $blockModel->getHtml(),
            'css'    => $blockModel->getCss(),
            'js'     => $blockModel->getJs(),
        ];
    }
}
