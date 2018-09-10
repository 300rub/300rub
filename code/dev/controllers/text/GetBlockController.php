<?php

namespace ss\controllers\text;

use ss\application\App;
use ss\application\components\user\Operation;

use ss\application\components\valueGenerator\ValueGenerator;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\text\TextModel;

/**
 * Gets block
 */
class GetBlockController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $name = '';
        $type = TextModel::TYPE_DIV;
        $hasEditor = false;
        $blockModel = new BlockModel();

        $blockId = (int)$this->get('id');

        if ($blockId === 0) {
            $this->checkBlockOperation(
                BlockModel::TYPE_TEXT,
                Operation::ALL,
                Operation::TEXT_ADD
            );
        }

        if ($blockId > 0) {
            $this->checkBlockOperation(
                BlockModel::TYPE_TEXT,
                $blockId,
                Operation::TEXT_UPDATE_SETTINGS
            );

            $blockModel = $blockModel->getById($blockId);
            $textModel = $blockModel->getContentModel(
                TextModel::CLASS_NAME
            );

            $name = $blockModel->get('name');
            $type = $textModel->get('type');
            $hasEditor = $textModel->get('hasEditor');
        }

        $language = App::getInstance()->getLanguage();

        $titleKey = 'editBlockTitle';
        $descriptionKey = 'editBlockDescription';
        $buttonKey = 'update';
        if ($blockId === 0) {
            $titleKey = 'addBlockTitle';
            $descriptionKey = 'addBlockDescription';
            $buttonKey = 'add';
        }

        $typeList = App::getInstance()
            ->getValueGenerator()
            ->getValue(
                ValueGenerator::ORDERED_ARRAY,
                TextModel::model()->getTypeList()
            );

        return [
            'id'          => $blockId,
            'title'       => $language->getMessage('text', $titleKey),
            'description' => $language->getMessage('text', $descriptionKey),
            'labels'      => [
                'duplicate'         => $language->getMessage('common', 'duplicate'),
                'delete'            => $language->getMessage('common', 'delete'),
                'deleteConfirmText' => $language->getMessage('text', 'deleteConfirmText'),
                'no'                => $language->getMessage('common', 'no'),
            ],
            'forms'       => [
                'name'      => [
                    'name'       => 'name',
                    'label'      => $language->getMessage('common', 'name'),
                    'validation'
                        => $blockModel->getValidationRulesForField('name'),
                    'value'      => $name,
                ],
                'type'      => [
                    'label' => $language->getMessage('common', 'type'),
                    'value' => $type,
                    'name'  => 'type',
                    'list'  => $typeList
                ],
                'hasEditor' => [
                    'name'  => 'hasEditor',
                    'label' => $language->getMessage('text', 'hasEditor'),
                    'value' => $hasEditor,
                ],
                'button'    => [
                    'label' => $language->getMessage('common', $buttonKey),
                ]
            ]
        ];
    }
}
