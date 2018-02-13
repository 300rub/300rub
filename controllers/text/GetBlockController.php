<?php

namespace ss\controllers\text;

use ss\application\App;
use ss\application\components\Operation;
use ss\application\components\ValueGenerator;
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
                false,
                null,
                TextModel::CLASS_NAME
            );

            $name = $blockModel->get('name');
            $type = $textModel->get('type');
            $hasEditor = $textModel->get('hasEditor');
        }

        $language = App::web()->getLanguage();

        $titleKey = 'editBlockTitle';
        $descriptionKey = 'editBlockDescription';
        $buttonKey = 'update';
        if ($blockId === 0) {
            $titleKey = 'addBlockTitle';
            $descriptionKey = 'addBlockDescription';
            $buttonKey = 'add';
        }

        $textModel = new TextModel();

        return [
            'id'          => $blockId,
            'title'       => $language->getMessage('text', $titleKey),
            'description' => $language->getMessage('text', $descriptionKey),
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
                    'list'  => ValueGenerator::factory(
                        ValueGenerator::ORDERED_ARRAY,
                        $textModel->getTypeList()
                    )->generate()
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
