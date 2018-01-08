<?php

namespace testS\controllers\text;

use testS\application\App;
use testS\application\components\Operation;
use testS\application\exceptions\NotFoundException;
use testS\controllers\_abstract\AbstractController;
use testS\models\blocks\block\BlockModel;
use testS\models\blocks\text\TextInstanceModel;
use testS\models\blocks\text\TextModel;

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

        $blockModel = new BlockModel();
        $blockModel = $blockModel->getById($blockId);
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
