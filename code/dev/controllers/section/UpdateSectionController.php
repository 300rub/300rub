<?php

namespace ss\controllers\section;

use ss\application\components\user\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\sections\SectionModel;

/**
 * Updates section
 */
class UpdateSectionController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkSectionOperation(
            Operation::SECTION_UPDATE_SETTINGS
        );

        $this->checkData(
            [
                'id'          => [self::TYPE_INT, self::NOT_EMPTY],
                'name'        => [self::TYPE_STRING],
                'alias'       => [self::TYPE_STRING],
                'title'       => [self::TYPE_STRING],
                'keywords'    => [self::TYPE_STRING],
                'description' => [self::TYPE_STRING],
                'isPublished' => [self::TYPE_BOOL],
            ]
        );

        $sectionModel = $this->_getSectionModel();
        $sectionModel->set(
            [
                'seoModel' => [
                    'name'        => $this->get('name'),
                    'alias'       => $this->get('alias'),
                    'title'       => $this->get('title'),
                    'keywords'    => $this->get('keywords'),
                    'description' => $this->get('description'),
                ],
                'isPublished' => $this->get('isPublished'),
            ]
        );

        if ($this->get('isMain') === true) {
            $sectionModel->set(
                [
                    'isMain' => true,
                ]
            );
        }

        $sectionModel->save();
        $errors = $sectionModel->getParsedErrors();
        if (count($errors) > 0) {
            $this->removeSavedData();

            return [
                'errors' => $errors
            ];
        }

        return $this->getSimpleSuccessResult();
    }

    /**
     * Gets Section model
     *
     * @return SectionModel
     *
     * @throws NotFoundException
     */
    private function _getSectionModel()
    {
        $sectionModel = SectionModel::model()
            ->withRelations(['seoModel'])
            ->byId($this->get('id'))
            ->find();

        if ($sectionModel === null) {
            throw new NotFoundException(
                'Unable to find section by ID: {id}',
                [
                    'id' => $this->get('id')
                ]
            );
        }

        return $sectionModel;
    }
}
