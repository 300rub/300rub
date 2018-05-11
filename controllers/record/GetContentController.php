<?php

namespace ss\controllers\record;

use ss\application\exceptions\NotFoundException;
use ss\controllers\_abstract\AbstractController;
use ss\models\blocks\block\BlockModel;
use ss\models\blocks\record\RecordModel;
use ss\models\sections\SectionModel;

/**
 * Gets content
 */
class GetContentController extends AbstractController
{

    /**
     * Runs controller
     *
     * @return array
     */
    public function run()
    {
        return [
            'html' => $this->_getRecordModel()->getInstancesHtml(
                (int)$this->get('page'),
                $this->_getSectionModel()->getUrl()
            )
        ];
    }

    /**
     * Gets record model
     *
     * @return RecordModel
     */
    private function _getRecordModel()
    {
        $blockModel = BlockModel::model()->getById($this->get('blockId'));
        return $blockModel->getContentModel(
            RecordModel::CLASS_NAME
        );
    }

    /**
     * Gets section model
     *
     * @return SectionModel
     *
     * @throws NotFoundException
     */
    private function _getSectionModel()
    {
        $sectionId = (int)$this->get('sectionId');

        $section = SectionModel::model()
            ->byId($sectionId)
            ->withRelations(['seoModel'])
            ->find();
        if ($section === null) {
            throw new NotFoundException(
                'Unable to find section with ID: {id}',
                [
                    'id' => $sectionId
                ]
            );
        }

        return $section;
    }
}
