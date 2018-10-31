<?php

namespace ss\controllers\section;

use ss\application\App;
use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\sections\SectionModel;

/**
 * Gets a list of codes
 */
class GetListController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkSectionOperation();

        $language = App::getInstance()->getLanguage();

        $list = [];
        $sectionModels = SectionModel::model()
            ->byLanguage($language->getActiveId())
            ->withRelations(['seoModel'])
            ->ordered('name', 'seoModel')
            ->findAll();

        foreach ($sectionModels as $sectionModel) {
            $canUpdateSettings = $this->hasBlockOperation(
                $sectionModel->getId(),
                Operation::SECTION_UPDATE_SETTINGS
            );
            $canUpdateDesign = $this->hasBlockOperation(
                $sectionModel->getId(),
                Operation::SECTION_UPDATE_DESIGN
            );
            $canUpdateContent = $this->hasBlockOperation(
                $sectionModel->getId(),
                Operation::SECTION_UPDATE_CONTENT
            );

            if ($canUpdateSettings === false
                && $canUpdateDesign === false
                && $canUpdateContent === false
            ) {
                continue;
            }

            $list[] = [
                'id'                => $sectionModel->getId(),
                'name'
                    => $sectionModel->get('seoModel')->get('name'),
                'isMain'            => $sectionModel->get('isMain'),
                'isPublished'       => $sectionModel->get('isPublished'),
                'canUpdateSettings' => $canUpdateSettings,
                'canUpdateDesign'   => $canUpdateDesign,
                'canUpdateContent'  => $canUpdateContent,
            ];
        }

        $canAdd = $this->hasSectionOperation(
            Operation::ALL,
            Operation::SECTION_ADD
        );

        return [
            'title'       => $language->getMessage('section', 'sections'),
            'description'
                => $language->getMessage('section', 'panelDescription'),
            'list'        => $list,
            'labels'      => [
                'add' => $language->getMessage('common', 'add')
            ],
            'canAdd'      => $canAdd
        ];
    }
}
