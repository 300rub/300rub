<?php

namespace ss\controllers\section;

use ss\application\components\user\Operation;
use ss\controllers\_abstract\AbstractController;
use ss\models\sections\SectionModel;

/**
 * Creates section
 */
class CreateSectionController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkSectionOperation(
            Operation::SECTION_ADD
        );

        $this->checkData(
            [
                'name'        => [self::TYPE_STRING],
                'alias'       => [self::TYPE_STRING],
                'title'       => [self::TYPE_STRING],
                'keywords'    => [self::TYPE_STRING],
                'description' => [self::TYPE_STRING],
                'isPublished' => [self::TYPE_BOOL],
                'isMain'      => [self::TYPE_BOOL],
            ]
        );

        $sectionModel = new SectionModel();
        $sectionModel->set(
            [
                'seoModel'    => [
                    'name'        => $this->get('name'),
                    'alias'       => $this->get('alias'),
                    'title'       => $this->get('title'),
                    'keywords'    => $this->get('keywords'),
                    'description' => $this->get('description'),
                ],
                'isPublished' => $this->get('isPublished'),
                'isMain'      => $this->get('isMain'),
            ]
        );
        $sectionModel->save();

        $errors = $sectionModel->getParsedErrors();
        if (count($errors) > 0) {
            $this->removeSavedData();

            return [
                'errors' => $errors
            ];
        }

        return [
            'sectionId' => $sectionModel->getId()
        ];
    }
}
