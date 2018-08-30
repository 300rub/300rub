<?php

namespace ss\controllers\section;

use ss\application\App;
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
            $list[] = [
                'id'          => $sectionModel->getId(),
                'name'        => $sectionModel->get('seoModel')->get('name'),
                'isMain'      => $sectionModel->get('isMain'),
                'isPublished' => $sectionModel->get('isPublished'),
            ];
        }

        return [
            'title'       => $language->getMessage('section', 'sections'),
            'description' => $language->getMessage('section', 'panelDescription'),
            'list'        => $list
        ];
    }
}
