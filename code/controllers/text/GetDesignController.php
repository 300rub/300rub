<?php

namespace ss\controllers\text;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\application\exceptions\BadRequestException;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractBlockController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\text\TextModel;

/**
 * Gets block's design
 */
class GetDesignController extends AbstractBlockController
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
                'blockId' => [self::NOT_EMPTY],
            ]
        );

        $blockId = (int)$this->get('blockId');

        $this->checkBlockOperation(
            BlockModel::TYPE_TEXT,
            $blockId,
            Operation::TEXT_UPDATE_DESIGN
        );

        $textModel = $this->_getTextModel($blockId);
        $cssSelector = sprintf('.block-%s', $blockId);

        $data = [];

        $data[] = $textModel
            ->getDesignBlockModel()
            ->setCreateGroup('text')
            ->setCreateController('designImage')
            ->setCropGroup('text')
            ->setCropController('designImageCrop')
            ->setRemoveGroup('text')
            ->setRemoveController('designImage')
            ->getDesign($cssSelector);

        if ($textModel->get('hasEditor') === false) {
            $data[] = $textModel
                ->getDesignTextModel()
                ->getDesign($cssSelector);
        }

        $language = App::getInstance()->getLanguage();

        return [
            'blockId'     => $blockId,
            'group'       => 'text',
            'controller'  => 'design',
            'title'       => $language->getMessage('text', 'designTitle'),
            'description' => $language->getMessage('text', 'designDescription'),
            'list'        => [
                [
                    'title' => $language->getMessage('text', 'designTitle'),
                    'data'  => $data
                ]
            ],
            'labels'     => [
                'button' => $language->getMessage('common', 'save'),
            ]
        ];
    }

    /**
     * Gets text model
     *
     * @param integer $blockId Block ID
     *
     * @return TextModel
     */
    private function _getTextModel($blockId)
    {
        return BlockModel::model()
            ->getById($blockId)
            ->getContentModel(
                TextModel::CLASS_NAME
            );
    }
}
