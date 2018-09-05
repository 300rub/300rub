<?php

namespace ss\controllers\section;

use ss\application\components\user\Operation;
use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\sections\SectionModel;

/**
 * Deletes section
 */
class DeleteSectionController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        $this->checkSectionOperation(
            Operation::SECTION_DELETE
        );

        $this->checkData(
            [
                'id' => [self::TYPE_INT, self::NOT_EMPTY],
            ]
        );

        $this->_getSectionModel()->delete();

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
            ->withRelations(['seoModel', 'designBlockModel'])
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
