<?php

namespace ss\controllers\text;

use ss\application\App;
use ss\application\components\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\text\TextInstanceModel;
use ss\models\blocks\text\TextModel;

/**
 * Gets block's content
 */
class GetContentController extends AbstractController
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
                'id' => [self::NOT_EMPTY],
            ]
        );

        $blockId = (int)$this->get('id');

        $this->checkBlockOperation(
            BlockModel::TYPE_TEXT,
            $blockId,
            Operation::TEXT_UPDATE_CONTENT
        );

        $blockModel = BlockModel::model()->getById($blockId);
        $textModel = $blockModel->getContentModel(
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

        $language = App::web()->getLanguage();

        return [
            'id'        => $blockModel->getId(),
            'name'      => $blockModel->get('name'),
            'type'      => $textModel->get('type'),
            'hasEditor' => $textModel->get('hasEditor'),
            'text'      => [
                'name'  => 'text',
                'label' => $language->getMessage('text', 'text'),
                'value' => $textInstanceModel->get('text'),
            ],
            'button'    => [
                'label' => $language->getMessage('common', 'update'),
            ]
        ];
    }
}
