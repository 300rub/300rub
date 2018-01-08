<?php

namespace testS\controllers\text;

use testS\application\App;
use testS\application\components\Operation;
use testS\application\exceptions\BadRequestException;
use testS\controllers\_abstract\AbstractController;
use testS\models\blocks\block\BlockModel;
use testS\models\blocks\text\TextInstanceModel;
use testS\models\blocks\text\TextModel;

/**
 * Adds block
 */
class CreateBlockController extends AbstractController
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
                'language'    => App::web()->getLanguage()->getActiveId(),
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

        return $this->getSimpleSuccessResult();
    }
}
