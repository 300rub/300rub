<?php

namespace ss\controllers\text;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\sections\SectionModel;
use ss\models\sections\SeoModel;

/**
 * Gets settings
 */
class GetSectionController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $sectionModel = new SectionModel();
        $seoModel = new SeoModel();
        $sectionId = (int)$this->get('id');

        if ($sectionId === 0) {
            $this->checkSectionOperation(
                Operation::SECTION_ADD
            );
        }

        if ($sectionId > 0) {
            $this->checkSectionOperation(
                Operation::SECTION_UPDATE_SETTINGS
            );

            $sectionModel = SectionModel::model()
                ->withRelations(['seoModel'])
                ->byId($sectionId);
            $seoModel = $sectionModel->get('seoModel');
        }

        $language = App::getInstance()->getLanguage();

        $titleKey = 'editSettingsTitle';
        $descriptionKey = 'editSettingsDescription';
        $buttonKey = 'update';
        if ($sectionId === 0) {
            $titleKey = 'addSettingsTitle';
            $descriptionKey = 'addSettingsDescription';
            $buttonKey = 'add';
        }

        return [
            'id'          => $sectionId,
            'title'       => $language->getMessage('section', $titleKey),
            'description' => $language->getMessage('section', $descriptionKey),
            'forms'       => [
                'name'  => [
                    'name'  => 'name',
                    'label' => $language->getMessage('common', 'name'),
                    'validation'
                        => $seoModel->getValidationRulesForField('name'),
                    'value' => $seoModel->get('name'),
                ],
                'alias' => [
                    'name'  => 'alias',
                    'label' => $language->getMessage('common', 'alias'),
                    'validation'
                        => $seoModel->getValidationRulesForField('alias'),
                    'value' => $seoModel->get('alias'),
                ],
                'title' => [
                    'name'  => 'title',
                    'label' => $language->getMessage('common', 'title'),
                    'validation'
                        => $seoModel->getValidationRulesForField('title'),
                    'value' => $seoModel->get('title'),
                ],
                'keywords' => [
                    'name'  => 'keywords',
                    'label' => $language->getMessage('common', 'keywords'),
                    'validation'
                        => $seoModel->getValidationRulesForField('keywords'),
                    'value' => $seoModel->get('keywords'),
                ],
                'description' => [
                    'name'  => 'description',
                    'label' => $language->getMessage('common', 'description'),
                    'validation'
                        => $seoModel->getValidationRulesForField('description'),
                    'value' => $seoModel->get('description'),
                ],
                'isMain' => [
                    'name'  => 'isMain',
                    'label' => $language->getMessage('section', 'main'),
                    'value' => $sectionModel->get('isMain'),
                ],
                'isPublished' => [
                    'name'  => 'isPublished',
                    'label' => $language->getMessage('section', 'main'),
                    'value' => $sectionModel->get('isPublished'),
                ],
                'button'    => [
                    'label' => $language->getMessage('common', $buttonKey),
                ]
            ]
        ];
    }
}
