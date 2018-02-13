<?php

namespace ss\controllers\text;

use ss\application\components\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\text\TextInstanceModel;
use ss\models\blocks\text\TextModel;

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

        $blockModel = BlockModel::model()->getById($this->get('id'));
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
