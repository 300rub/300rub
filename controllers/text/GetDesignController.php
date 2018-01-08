<?php

namespace testS\controllers\text;

use testS\application\App;
use testS\application\components\Operation;
use testS\application\exceptions\BadRequestException;
use testS\application\exceptions\NotFoundException;
use testS\controllers\_abstract\AbstractController;
use testS\models\blocks\block\BlockModel;
use testS\models\blocks\text\TextModel;

/**
 * Gets block's design
 */
class GetDesignController extends AbstractController
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
                'id' => [self::NOT_EMPTY],
            ]
        );

        $blockId = (int)$this->get('id');

        $this->checkBlockOperation(
            BlockModel::TYPE_TEXT,
            $blockId,
            Operation::TEXT_UPDATE_DESIGN
        );

        $textModel = $this->_getTextModel($blockId);
        $cssSelector = sprintf('.block-%s', $blockId);
        $blockDesign = $textModel
            ->getDesignBlockModel()
            ->getDesign($cssSelector);
        $textDesign = $textModel
            ->getDesignTextModel()
            ->getDesign($cssSelector);

        $language = App::web()->getLanguage();

        return [
            'id'          => $blockId,
            'controller'  => 'text',
            'action'      => 'design',
            'title'       => $language->getMessage('text', 'designTitle'),
            'description' => $language->getMessage('text', 'designDescription'),
            'list'        => [
                [
                    'title' => $language->getMessage('text', 'designTitle'),
                    'data'  => [$blockDesign, $textDesign]
                ]
            ],
            'button'     => [
                'label' => $language->getMessage('common', 'save'),
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
                true,
                null,
                TextModel::CLASS_NAME
            );
    }
}
