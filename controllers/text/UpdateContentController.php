<?php

namespace testS\controllers\text;

use testS\application\components\Operation;
use testS\application\exceptions\NotFoundException;
use testS\controllers\_abstract\AbstractController;
use testS\models\blocks\block\BlockModel;
use testS\models\blocks\text\TextInstanceModel;
use testS\models\blocks\text\TextModel;

/**
 * Updates block's content
 */
class UpdateContentController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     *
     * @throws NotFoundException
     */
    public function run()
    {
        $this->checkData(
            [
                'id'   => [self::TYPE_INT, self::NOT_EMPTY],
                'text' => [self::TYPE_STRING],
            ]
        );

        $this->checkBlockOperation(
            BlockModel::TYPE_TEXT,
            $this->get('id'),
            Operation::TEXT_UPDATE_CONTENT
        );

        $blockModel = new BlockModel();
        $blockModel = $blockModel->getById($this->get('id'));
        $textModel = $blockModel->getContentModel(
            false,
            null,
            TextModel::CLASS_NAME
        );

        $textInstanceModel = new TextInstanceModel();
        $textInstanceModel->byTextId($textModel->getId());
        $textInstanceModel = $textInstanceModel->find();
        if ($textInstanceModel === null) {
            throw new NotFoundException(
                'Unable to find TextInstanceModel by text ID: {id}',
                [
                    'id' => $textModel->getId()
                ]
            );
        }

        $textInstanceModel->set(
            [
                'text' => $this->get('text')
            ]
        );
        $textInstanceModel->save();

        $blockModel->setContent();

        return [
            'result' => true,
            'html'   => $blockModel->getHtml(),
            'css'    => $blockModel->getCss(),
            'js'     => $blockModel->getJs(),
        ];
    }
}
